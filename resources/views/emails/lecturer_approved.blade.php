<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Access {{ $alreadyApproved ? 'Already Granted' : 'Approved' }}</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f5f5f5; }
        .card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; max-width: 480px; }
        .icon { font-size: 48px; margin-bottom: 16px; }
        h2 { color: #333; margin-bottom: 8px; }
        p { color: #666; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="card">
        @if($alreadyApproved)
            <div class="icon">ℹ️</div>
            <h2>Already a Lecturer</h2>
            <p><strong>{{ $name }}</strong> already has lecturer access.</p>
        @else
            <div class="icon">✅</div>
            <h2>Lecturer Access Approved</h2>
            <p><strong>{{ $name }}</strong> has been elevated to lecturer role.</p>
            <p>They will be logged out automatically and can re-login to access the lecturer dashboard.</p>
        @endif
    </div>
</body>
</html>
