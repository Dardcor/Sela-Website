<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Access Request</title>
</head>
<body>
    <h2>Lecturer Access Request</h2>
    <p>A user has requested lecturer access. Here are their details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $user->full_name ?? $user->username }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>User ID:</strong> {{ $user->id }}</li>
    </ul>
    <p>Click the button below to approve this request:</p>
    <p>
        <a href="{{ $approveUrl }}"
           style="display:inline-block;padding:12px 24px;background-color:#2196F3;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:bold;">
            Approve Lecturer Access
        </a>
    </p>
    <p style="margin-top:16px;color:#666;font-size:13px;">
        Or copy this link: <a href="{{ $approveUrl }}">{{ $approveUrl }}</a>
    </p>
</body>
</html>
