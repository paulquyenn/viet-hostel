<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // Sử dụng properties chỉ định để giảm dung lượng bộ nhớ khi serialize notification
    protected $paymentId;
    protected $paymentNumber;
    protected $amount;
    protected $paymentDate;
    protected $paymentPeriodStart;
    protected $paymentPeriodEnd;
    protected $paidAt;
    protected $roomNumber;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment, string $type)
    {
        // Lưu trữ chỉ các thuộc tính cần thiết để giảm dung lượng bộ nhớ
        $this->paymentId = $payment->id;
        $this->paymentNumber = $payment->payment_number;
        $this->amount = $payment->amount;
        $this->paymentDate = $payment->payment_date;
        $this->paymentPeriodStart = $payment->payment_period_start;
        $this->paymentPeriodEnd = $payment->payment_period_end;
        $this->paidAt = $payment->paid_at ?? null;
        $this->roomNumber = $payment->contract->room->room_number ?? 'N/A';
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Thông báo thanh toán #' . $this->paymentNumber)
            ->greeting('Xin chào ' . $notifiable->name . '!');

        switch ($this->type) {
            case 'created':
                $mailMessage->line('Một khoản thanh toán mới đã được tạo cho hợp đồng thuê phòng ' . $this->roomNumber . '.')
                    ->line('Số tiền: ' . number_format($this->amount) . ' VND')
                    ->line('Kỳ thanh toán: ' . $this->paymentPeriodStart->format('d/m/Y') . ' đến ' . $this->paymentPeriodEnd->format('d/m/Y'))
                    ->line('Hạn thanh toán: ' . $this->paymentDate->format('d/m/Y'));
                break;

            case 'paid':
                $mailMessage->line('Khoản thanh toán cho hợp đồng thuê phòng ' . $this->roomNumber . ' đã được thanh toán.')
                    ->line('Số tiền: ' . number_format($this->amount) . ' VND')
                    ->line('Kỳ thanh toán: ' . $this->paymentPeriodStart->format('d/m/Y') . ' đến ' . $this->paymentPeriodEnd->format('d/m/Y'));

                if ($this->paidAt) {
                    $mailMessage->line('Ngày thanh toán: ' . $this->paidAt->format('d/m/Y'));
                }
                break;

            case 'overdue':
                $mailMessage->line('Khoản thanh toán cho hợp đồng thuê phòng ' . $this->roomNumber . ' đã quá hạn.')
                    ->line('Số tiền: ' . number_format($this->amount) . ' VND')
                    ->line('Kỳ thanh toán: ' . $this->paymentPeriodStart->format('d/m/Y') . ' đến ' . $this->paymentPeriodEnd->format('d/m/Y'))
                    ->line('Hạn thanh toán: ' . $this->paymentDate->format('d/m/Y'))
                    ->line('Vui lòng thanh toán sớm để tránh các vấn đề phát sinh.');
                break;

            case 'upcoming':
                $mailMessage->line('Nhắc nhở: Bạn có một khoản thanh toán sắp đến hạn cho hợp đồng thuê phòng ' . $this->roomNumber . '.')
                    ->line('Số tiền: ' . number_format($this->amount) . ' VND')
                    ->line('Kỳ thanh toán: ' . $this->paymentPeriodStart->format('d/m/Y') . ' đến ' . $this->paymentPeriodEnd->format('d/m/Y'))
                    ->line('Hạn thanh toán: ' . $this->paymentDate->format('d/m/Y'));
                break;
        }

        return $mailMessage
            ->action('Xem chi tiết thanh toán', url('/payments/' . $this->paymentId))
            ->line('Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!')
            ->salutation('Trân trọng,');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $title = '';
        $message = '';

        switch ($this->type) {
            case 'created':
                $title = 'Khoản thanh toán mới';
                $message = 'Khoản thanh toán mới đã được tạo cho phòng ' . $this->roomNumber .
                    ', số tiền ' . number_format($this->amount) . ' VND, hạn thanh toán ' . $this->paymentDate->format('d/m/Y');
                break;

            case 'paid':
                $title = 'Khoản thanh toán đã được thanh toán';
                $message = 'Khoản thanh toán cho phòng ' . $this->roomNumber .
                    ' đã được thanh toán, số tiền ' . number_format($this->amount) . ' VND';
                break;

            case 'overdue':
                $title = 'Khoản thanh toán quá hạn';
                $message = 'Khoản thanh toán cho phòng ' . $this->roomNumber .
                    ' đã quá hạn, số tiền ' . number_format($this->amount) . ' VND';
                break;

            case 'upcoming':
                $title = 'Nhắc nhở thanh toán';
                $message = 'Sắp đến hạn thanh toán cho phòng ' . $this->roomNumber .
                    ', số tiền ' . number_format($this->amount) . ' VND, hạn thanh toán ' . $this->paymentDate->format('d/m/Y');
                break;
        }

        return [
            'payment_id' => $this->paymentId,
            'payment_number' => $this->paymentNumber,
            'room_number' => $this->roomNumber,
            'amount' => $this->amount,
            'payment_date' => $this->paymentDate->format('Y-m-d'),
            'type' => $this->type,
            'title' => $title,
            'message' => $message,
            'url' => '/payments/' . $this->paymentId
        ];
    }
}
