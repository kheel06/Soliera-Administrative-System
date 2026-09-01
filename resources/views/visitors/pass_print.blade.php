<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Pass - {{ $visitor->name }}</title>
    <!-- Gagamit tayo ng Jakarta Sans gaya ng nasa screenshot -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: #f8fafc;
        }

        .page-container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        /* The ID Card - Matching "Half Index Card Size" proportions */
        .id-card {
            width: 820px;
            height: 520px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            position: relative;
        }

        /* Left Side - Dark Navy Section (#0F172A to #1E293B) */
        .left-side {
            width: 38%;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            padding: 30px;
            text-align: center;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Right Side - White Section */
        .right-side {
            width: 62%;
            background: #fff;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        /* Header Elements */
        .badge-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-circle {
            width: 32px;
            height: 32px;
            background: #14b8a6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
            color: white;
        }

        .logo-text {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.5px;
            color: white;
        }

        /* VISITOR pill - Orange (#F97316) */
        .visitor-pill {
            background: #f97316;
            color: white;
            font-size: 11px;
            font-weight: 800;
            padding: 7px 18px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Profile Photo Section */
        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .photo-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .photo-circle {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            border: 5px solid #f97316;
            padding: 4px;
            overflow: hidden;
            background: #1e293b;
        }

        .photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .verified-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            background: #14b8a6;
            border: 3px solid #0f172a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .visitor-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .role-pill {
            background: rgba(255, 255, 255, 0.12);
            padding: 6px 20px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 600;
            color: #cbd5e1;
        }

        /* Right Side Content Layout */
        .info-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        /* Labels: 9px, #676F7E, Uppercase, Tracking-wider */
        .label {
            font-size: 9px;
            font-weight: 600;
            color: #676F7E;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 2px;
        }

        /* Info Card: Bg #E8EAEE at 50% opacity, Rounded LG, Padding 10px */
        .info-box {
            flex: 1;
            background: #E8EAEE80;
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid rgba(226, 232, 240, 0.5);
        }

        .value {
            font-size: 16px;
            font-weight: 700;
            color: #0F1729;
            line-height: 1.2;
        }

        .spacer {
            flex: 1;
        }

        /* Bottom Layout for PASS ID & QR */
        .bottom-layout {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
        }

        .pass-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .pass-id-box {
            background: #E8EAEE80;
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid rgba(226, 232, 240, 0.5);
        }

        .pass-id-value {
            font-size: 15px;
            font-weight: 700;
            color: #0F1729;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            text-transform: uppercase;
        }

        /* Wear notice: #0F8A71, 9px, Semibold */
        .wear-notice {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 9px;
            font-weight: 600;
            color: #0F8A71;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .privacy-notice {
            font-size: 7.5px;
            color: #64748B;
            font-style: italic;
            line-height: 1.5;
            text-align: justify;
            margin: 0;
        }

        .privacy-notice strong {
            color: #475569;
            font-style: normal;
            font-size: 8px;
        }

        .wear-icon-circle {
            width: 16px;
            height: 16px;
            border: 1.5px solid #0F8A71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
        }

        /* QR Code Card - White, Padded, Shadowed */
        .qr-card {
            background: #FFFFFF;
            padding: 8px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin-left: 12px;
        }

        .qr-img {
            width: 90px;
            height: 90px;
            display: block;
        }

        .scan-text {
            font-size: 8px;
            color: #94a3b8;
            margin-top: 6px;
            font-weight: 600;
        }

        @media print {
            body {
                background: #fff;
            }

            .id-card {
                box-shadow: none;
                border: 1px solid #eee;
            }
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="id-card">
            <!-- Left Side - Dark Section -->
            <div class="left-side">
                <div class="badge-header">
                    <div class="logo-group">
                        <div class="logo-circle">S</div>
                        <span class="logo-text">SOLIERA</span>
                    </div>
                    <span class="visitor-pill">VISITOR</span>
                </div>

                <div class="profile-section">
                    <div class="photo-wrapper">
                        <div class="photo-circle">
                            @if(isset($profilePhotoBase64) && $profilePhotoBase64)
                                <img src="{{ $profilePhotoBase64 }}" alt="Photo">
                            @elseif($visitor->profile_photo_url)
                                <img src="{{ $visitor->profile_photo_url }}" alt="Photo">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($visitor->name) }}&background=1e293b&color=fff&size=200"
                                    alt="Photo">
                            @endif
                        </div>
                        <div class="verified-badge">✓</div>
                    </div>

                    <!-- Removed name here as per request -->
                    <!-- Removed department from left side -->
                </div>
            </div>

            <!-- Right Side - White Section -->
            <div class="right-side">
                <!-- Row 1: Full Name & Room -->
                <div class="info-row">
                    <div class="info-box">
                        <p class="label">FULL NAME</p>
                        <p class="value" style="font-size: 18px;">{{ strtoupper($visitor->name) }}</p>
                    </div>
                    <div class="info-box">
                        <p class="label">ROOM</p>
                        <p class="value">{{ $visitor->room ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Row 2: Time In & Time Out -->
                <div class="info-row" style="margin-top: -10px;">
                    <div class="info-box">
                        <p class="label">TIME IN</p>
                        <p class="value">
                            {{ $visitor->time_in ? \Carbon\Carbon::parse($visitor->time_in)->format('M d, H:i') : 'N/A' }}
                        </p>
                    </div>
                    <div class="info-box">
                        <p class="label">TIME OUT</p>
                        <p class="value">
                            {{ $visitor->expected_time_out ? \Carbon\Carbon::parse($visitor->expected_time_out)->format('M d, H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Row 3: Purpose & Phone -->
                <div class="info-row" style="margin-top: -10px;">
                    <div class="info-box">
                        <p class="label">PURPOSE</p>
                        <p class="value">{{ $visitor->purpose ?? 'N/A' }}</p>
                    </div>
                    <div class="info-box">
                        <p class="label">PHONE</p>
                        <p class="value">{{ $visitor->contact ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Row 4: Department & Email -->
                <div class="info-row" style="margin-top: -10px;">
                    <div class="info-box">
                        <p class="label">DEPARTMENT</p>
                        <p class="value">{{ $visitor->department ?? 'N/A' }}</p>
                    </div>
                    <div class="info-box">
                        <p class="label">EMAIL</p>
                        <p class="value"
                            style="font-size: 13px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $visitor->email ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Data Privacy Section -->
                <div class="privacy-container" style="margin-top: 5px; padding: 0 5px;">
                    <p class="privacy-notice">
                        <strong>DATA PRIVACY CONSENT:</strong> By accepting this pass, you express consent to the
                        collection, use,
                        and processing of your personal data for security monitoring and visitor management purposes,
                        fully compliant with the Data Privacy Act and our company's Privacy Policy.
                    </p>
                </div>

                <div class="spacer"></div>

                <div class="bottom-layout">
                    <div class="pass-container">
                        <div class="pass-id-box">
                            <p class="label">PASS ID</p>
                            <p class="pass-id-value">{{ $visitor->pass_id }}</p>
                        </div>
                        <div class="wear-notice">
                            <div class="wear-icon-circle">i</div>
                            WEAR BADGE AT ALL TIMES
                        </div>
                    </div>

                    <div class="qr-card">
                        @if(isset($qrBase64) && $qrBase64)
                            <img src="{{ $qrBase64 }}" class="qr-img" alt="QR">
                        @else
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $visitor->pass_id }}"
                                class="qr-img" alt="QR">
                        @endif
                        <p class="scan-text">Scan to verify</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 500);
        };
    </script>
</body>

</html>