<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $type;

    public function __construct(Booking $booking, $type)
    {
        $this->booking = $booking;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = new MailMessage;
        
        switch ($this->type) {
            case 'created':
                $message->subject('تأكيد حجز جديد')
                    ->line('تم إنشاء حجز جديد بنجاح.')
                    ->line('تفاصيل الحجز:')
                    ->line('المحطة: ' . $this->booking->station->name)
                    ->line('التاريخ: ' . $this->booking->start_time->format('Y-m-d'))
                    ->line('الوقت: ' . $this->booking->start_time->format('H:i') . ' - ' . $this->booking->end_time->format('H:i'))
                    ->action('عرض تفاصيل الحجز', url('/bookings/' . $this->booking->id));
                break;

            case 'confirmed':
                $message->subject('تم تأكيد الحجز')
                    ->line('تم تأكيد حجزك في محطة ' . $this->booking->station->name)
                    ->line('موعد الحجز: ' . $this->booking->start_time->format('Y-m-d H:i'))
                    ->action('عرض تفاصيل الحجز', url('/bookings/' . $this->booking->id));
                break;

            case 'cancelled':
                $message->subject('تم إلغاء الحجز')
                    ->line('تم إلغاء حجزك في محطة ' . $this->booking->station->name)
                    ->line('موعد الحجز: ' . $this->booking->start_time->format('Y-m-d H:i'))
                    ->line('إذا كان لديك أي استفسار، يرجى التواصل مع خدمة العملاء.');
                break;

            case 'reminder':
                $message->subject('تذكير بموعد الحجز')
                    ->line('تذكير بموعد حجزك غداً في محطة ' . $this->booking->station->name)
                    ->line('التاريخ: ' . $this->booking->start_time->format('Y-m-d'))
                    ->line('الوقت: ' . $this->booking->start_time->format('H:i'))
                    ->action('عرض تفاصيل الحجز', url('/bookings/' . $this->booking->id));
                break;
        }

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => $this->type,
            'message' => $this->getNotificationMessage(),
            'station_name' => $this->booking->station->name,
            'start_time' => $this->booking->start_time->format('Y-m-d H:i'),
            'end_time' => $this->booking->end_time->format('Y-m-d H:i'),
        ];
    }

    private function getNotificationMessage()
    {
        switch ($this->type) {
            case 'created':
                return 'تم إنشاء حجز جديد في محطة ' . $this->booking->station->name;
            case 'confirmed':
                return 'تم تأكيد حجزك في محطة ' . $this->booking->station->name;
            case 'cancelled':
                return 'تم إلغاء حجزك في محطة ' . $this->booking->station->name;
            case 'reminder':
                return 'تذكير: لديك حجز غداً في محطة ' . $this->booking->station->name;
            default:
                return 'تحديث على حجزك في محطة ' . $this->booking->station->name;
        }
    }
} 