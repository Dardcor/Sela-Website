<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function getNotifications($userId, $isRead = null)
    {
        $query = Notification::where('user_id', $userId);
        
        if ($isRead !== null) {
            $isReadBool = filter_var($isRead, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_read', $isReadBool);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function createNotification(array $data)
    {
        return Notification::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'] ?? 'system',
            'related_id' => $data['related_id'] ?? null,
            'is_read' => false,
            'created_at' => now(),
        ]);
    }

    public function markAsRead($id)
    {
        return Notification::where('id', $id)->update(['is_read' => true]);
    }

    public function markMultipleAsRead(array $ids)
    {
        return Notification::whereIn('id', $ids)->update(['is_read' => true]);
    }

    public function markAllAsRead($userId)
    {
        return Notification::where('user_id', $userId)->update(['is_read' => true]);
    }

    public function deleteNotification($id)
    {
        return Notification::where('id', $id)->delete();
    }

    public function deleteMultipleNotifications(array $ids)
    {
        return Notification::whereIn('id', $ids)->delete();
    }
}
