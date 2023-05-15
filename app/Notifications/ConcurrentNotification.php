<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\{Concurrent, ServiceCommit};

class ConcurrentNotification extends Notification
{
	use Queueable;

	private $concurrent;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Concurrent $concurrent)
	{
		$this->concurrent = $concurrent;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array
	 */
	public function via(): array
	{
		return ['database'];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray($notifiable): array
	{
		$data = [];

		if ($this->concurrent->model_type === ServiceCommit::class) {
			$service_commit = ServiceCommit::find($this->concurrent->model_id);
			$date['title'] = $service_commit->service->title;
			$date['badge'] = $service_commit->badge;
			$date['location'] = $service_commit->from_location;
			$date['service_commit_id'] = __($this->concurrent->model_id);
		}

		return $data;
	}
}
