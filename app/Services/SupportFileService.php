<?php

namespace App\Services;

use App\Models\SupportFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class SupportFileService
{
    public function getByTask(int $taskId): Collection
    {
        return SupportFile::with('uploader')->where('task_id', $taskId)->get();
    }

    public function getById(int $id): SupportFile
    {
        return SupportFile::findOrFail($id);
    }

    public function upload(UploadedFile $file, int $taskId, int $uploadedBy): SupportFile
    {
        $path = $file->store("tasks/{$taskId}", 'public');

        return SupportFile::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'task_id' => $taskId,
            'uploaded_by' => $uploadedBy,
        ]);
    }

    public function delete(SupportFile $file): bool
    {
        return $file->delete();
    }
}
