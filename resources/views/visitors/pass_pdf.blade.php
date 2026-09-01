<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Visitor Pass</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #f8fafc;
        }

        /* Full page table for centering */
        .page-wrapper {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        .center-cell {
            vertical-align: middle;
            text-align: center;
        }

        /* The ID Card */
        .id-card {
            display: inline-block;
            width: 380px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-layout {
            width: 100%;
            border-collapse: collapse;
        }

        /* LEFT COLUMN - Dark Navy */
        .left-side {
            width: 40%;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
            vertical-align: top;
            text-align: center;
            padding: 20px 15px;
        }

        /* RIGHT COLUMN - White */
        .right-side {
            width: 60%;
            background: #ffffff;
            vertical-align: top;
            padding: 15px 18px;
        }

        /* Header with Logo and Visitor Badge */
        .header-row {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .logo-icon {
            display: inline-block;
            width: 22px;
            height: 22px;
            background: #14b8a6;
            border-radius: 50%;
            color: white;
            font-size: 12px;
            font-weight: bold;
            line-height: 22px;
            text-align: center;
            vertical-align: middle;
        }

        .logo-name {
            display: inline-block;
            color: white;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-left: 6px;
            vertical-align: middle;
        }

        .visitor-tag {
            position: absolute;
            right: 0;
            top: 0;
            background: #f59e0b;
            color: white;
            font-size: 9px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Photo Section */
        .photo-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 15px auto;
        }

        .photo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #f59e0b;
            overflow: hidden;
            background: #e2e8f0;
        }

        .photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .verified-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            background: #14b8a6;
            border: 3px solid #1e3a5f;
            border-radius: 50%;
            color: white;
            font-size: 14px;
            line-height: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Visitor Name */
        .visitor-name {
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Department Badge */
        .dept-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            padding: 5px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Info Boxes */
        .info-row {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 12px 14px;
            vertical-align: top;
        }

        .info-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: bold;
        }

        /* Bottom Section */
        .bottom-section {
            width: 100%;
            border-collapse: collapse;
        }

        .pass-section {
            vertical-align: bottom;
        }

        .pass-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }

        .pass-id {
            font-size: 15px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #0f172a;
        }

        .wear-badge-text {
            display: block;
            font-size: 11px;
            color: #14b8a6;
            font-weight: bold;
        }

        .info-icon {
            display: inline-block;
            font-size: 12px;
            margin-right: 4px;
            vertical-align: middle;
        }

        /* QR Section */
        .qr-section {
            vertical-align: bottom;
            text-align: right;
            width: 80px;
        }

        .qr-code {
            width: 65px;
            height: 65px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 4px;
            background: white;
        }

        .scan-label {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="page-wrapper">
        <tr>
            <td class="center-cell">

                <!-- ID Card -->
                <div class="id-card">
                    <table class="card-layout">
                        <tr>
                            <!-- LEFT SIDE -->
                            <td class="left-side">
                                <div class="header-row">
                                    <span class="logo-icon">S</span>
                                    <span class="logo-name">SOLIERA</span>
                                    <span class="visitor-tag">VISITOR</span>
                                </div>

                                <div class="photo-wrapper">
                                    <div class="photo-circle">
                                        @if(isset($profilePhotoBase64) && $profilePhotoBase64)
                                            <img src="{{ $profilePhotoBase64 }}" alt="Photo">
                                        @elseif($visitor->profile_photo_url)
                                            <img src="{{ $visitor->profile_photo_url }}" alt="Photo">
                                        @else
                                            <div
                                                style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#64748b; font-size:36px; font-weight:bold; line-height:100px; text-align:center;">
                                                {{ strtoupper(substr($visitor->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="verified-badge">✓</div>
                                </div>

                                <div class="visitor-name">{{ $visitor->name }}</div>
                                <div class="dept-badge">{{ $visitor->department ?? 'GUEST' }}</div>
                            </td>

                            <!-- RIGHT SIDE -->
                            <td class="right-side">
                                <table class="info-row">
                                    <tr>
                                        <td class="info-box" style="width: 50%;">
                                            <div class="info-label">HOST</div>
                                            <div class="info-value">{{ $visitor->host_employee ?? 'N/A' }}</div>
                                        </td>
                                        <td class="info-box" style="width: 50%;">
                                            <div class="info-label">VALID UNTIL</div>
                                            <div class="info-value">
                                                {{ $visitor->pass_valid_until ? $visitor->pass_valid_until->format('M d, H:i') : 'N/A' }}
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <table class="bottom-section">
                                    <tr>
                                        <td class="pass-section">
                                            <div class="pass-box">
                                                <div class="info-label">PASS ID</div>
                                                <div class="pass-id">{{ $visitor->pass_id }}</div>
                                            </div>
                                            <div class="wear-badge-text">
                                                <span class="info-icon">ⓘ</span> WEAR BADGE AT ALL TIMES
                                            </div>
                                        </td>
                                        <td class="qr-section">
                                            @if(isset($qrBase64) && $qrBase64)
                                                <img src="{{ $qrBase64 }}" class="qr-code" alt="QR Code">
                                            @else
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $visitor->pass_id }}"
                                                    class="qr-code" alt="QR Code">
                                            @endif
                                            <div class="scan-label">Scan to verify</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

            </td>
        </tr>
    </table>
</body>

</html>