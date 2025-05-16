<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contract;
    protected $statusChange;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contract $contract, string $statusChange, string $message = null)
    {
        $this->contract = $contract;
        $this->statusChange = $statusChange;
        $this->message = $message;
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
            ->subject('Thông báo về hợp đồng #' . $this->contract->contract_number)
            ->greeting('Xin chào ' . $notifiable->name . '!');

        switch ($this->statusChange) {
            case 'created':
                $mailMessage->line('Một hợp đồng mới đã được tạo cho phòng ' . $this->contract->room->room_number . '.')
                    ->line('Vui lòng đăng nhập vào hệ thống để xem chi tiết và tiến hành ký hợp đồng.');
                break;
            case 'signed':
                $mailMessage->line('Hợp đồng cho phòng ' . $this->contract->room->room_number . ' đã được ký bởi cả hai bên.')
                    ->line('Hợp đồng hiện đã có hiệu lực.');
                break;
            case 'terminated':
                $mailMessage->line('Hợp đồng cho phòng ' . $this->contract->room->room_number . ' đã bị chấm dứt.')
                    ->line('Lý do: ' . ($this->message ?? 'Không có lý do được cung cấp.'));
                break;
            case 'expired':
                $mailMessage->line('Hợp đồng cho phòng ' . $this->contract->room->room_number . ' đã hết hạn vào ngày ' . $this->contract->end_date->format('d/m/Y') . '.')
                    ->line('Vui lòng liên hệ để gia hạn hoặc thực hiện thủ tục bàn giao phòng.');
                break;
            case 'expiring_soon':
                $mailMessage->line('Hợp đồng cho phòng ' . $this->contract->room->room_number . ' sẽ hết hạn vào ngày ' . $this->contract->end_date->format('d/m/Y') . '.')
                    ->line('Vui lòng liên hệ để gia hạn hoặc chuẩn bị thủ tục bàn giao phòng.');
                break;
            default:
                $mailMessage->line('Có sự thay đổi về trạng thái hợp đồng cho phòng ' . $this->contract->room->room_number . '.');
                break;
        }

        return $mailMessage
            ->action('Xem hợp đồng', url('/contracts/' . $this->contract->id))
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

        switch ($this->statusChange) {
            case 'created':
                $title = 'Hợp đồng mới';
                break;
            case 'activated':
                $title = 'Hợp đồng đã kích hoạt';
                break;
            case 'expired':
                $title = 'Hợp đồng hết hạn';
                break;
            case 'terminated':
                $title = 'Hợp đồng chấm dứt';
                break;
            case 'signed_tenant':
                $title = 'Hợp đồng đã ký bởi người thuê';
                break;
            case 'signed_landlord':
                $title = 'Hợp đồng đã ký bởi chủ trọ';
                break;
            default:
                $title = 'Thông báo hợp đồng';
        }

        return [
            'contract_id' => $this->contract->id,
            'contract_number' => $this->contract->contract_number,
            'room_id' => $this->contract->room_id,
            'room_number' => $this->contract->room->room_number,
            'status_change' => $this->statusChange,
            'title' => $title,
            'message' => $this->message ?: 'Có thay đổi trong trạng thái hợp đồng của bạn',
            'url' => '/contracts/' . $this->contract->id
        ];
    }
}
