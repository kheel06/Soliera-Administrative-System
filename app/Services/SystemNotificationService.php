<?php

namespace App\Services;

use App\Models\DeptAccount;
use Illuminate\Support\Facades\Log;
use App\Notifications\SystemActionNotification;

class SystemNotificationService
{
    /**
     * Send notification for document actions
     */
    public static function notifyDocumentAction($action, $document, $user = null)
    {
        self::broadcastNotification([
            'title' => ucfirst($action) . ' Document',
            'message' => "Document '{$document->title}' has been {$action}",
            'type' => $action === 'deleted' ? 'error' : 'info',
            'category' => 'document',
            'severity' => $action === 'deleted' ? 'high' : 'medium',
            'action' => $action,
            'model_type' => 'document',
            'model_id' => $document->id
        ]);
    }

    /**
     * Send notification for contract actions
     */
    public static function notifyContractAction($action, $contract, $user = null)
    {
        $severity = 'medium';
        if (in_array($action, ['signed', 'expiring']))
            $severity = 'high';
        if ($action === 'expired')
            $severity = 'critical';

        self::broadcastNotification([
            'title' => 'Contract ' . ucfirst($action),
            'message' => "Contract '{$contract->title}' has been {$action}",
            'type' => $severity === 'critical' ? 'error' : ($severity === 'high' ? 'warning' : 'info'),
            'category' => 'contract',
            'severity' => $severity,
            'action' => $action,
            'model_type' => 'contract',
            'model_id' => $contract->id
        ]);
    }

    public static function notifyApprovalAction($action, $approval, $user = null)
    {
        $type = 'info';
        if ($action === 'approved' || $action === 'Approved')
            $type = 'success';
        if ($action === 'rejected' || $action === 'Rejected')
            $type = 'error';

        $title = $approval->title ?? $approval->name ?? 'Approval Request';

        self::broadcastNotification([
            'title' => 'Approval ' . ucfirst($action),
            'message' => "Request '{$title}' has been {$action}",
            'type' => $type,
            'category' => 'approval',
            'severity' => ($action === 'rejected' || $action === 'Rejected') ? 'high' : 'medium',
            'action' => $action,
            'model_type' => 'approval',
            'model_id' => $approval->id ?? null
        ]);
    }

    /**
     * Send notification for visitor actions
     */
    public static function notifyVisitorAction($action, $data, $user = null)
    {
        $visitorName = isset($data->name) ? $data->name : 'Unknown Visitor';
        $modelId = isset($data->id) ? $data->id : null;

        $actionText = $action;
        if ($action === 'checkin')
            $actionText = 'checked in';
        if ($action === 'checked_out')
            $actionText = 'checked out';
        if ($action === 'register')
            $actionText = 'registered';
        if ($action === 'scheduled')
            $actionText = 'scheduled a visit';
        if ($action === 'approved')
            $actionText = 'been approved';
        if ($action === 'denied')
            $actionText = 'been denied';

        $time = now()->format('h:i A');

        self::broadcastNotification([
            'title' => 'Visitor Alert',
            'message' => "Visitor '{$visitorName}' has {$actionText} at {$time}",
            'type' => $action === 'checkin' ? 'success' : ($action === 'checked_out' ? 'warning' : 'info'),
            'category' => 'visitor',
            'severity' => ($action === 'checkin' || $action === 'checked_out') ? 'medium' : 'low',
            'action' => $action,
            'model_type' => 'visitor',
            'model_id' => $modelId,
            'icon' => $action === 'checkin' ? 'user-plus' : ($action === 'checked_out' ? 'user-minus' : 'user-check')
        ]);
    }

    public static function notifyPermitAction($action, $permit, $user = null)
    {
        $severity = 'medium';
        if ($action === 'expiring')
            $severity = 'high';
        if ($action === 'expired')
            $severity = 'critical';

        self::broadcastNotification([
            'title' => 'Permit ' . ucfirst($action),
            'message' => "Permit '" . ($permit->name ?? 'Update') . "' is " . ($action === 'created' ? 'added' : ($action === 'updated' ? 'revised' : $action)),
            'type' => $severity === 'critical' ? 'error' : ($severity === 'high' ? 'warning' : 'info'),
            'category' => 'permit',
            'severity' => $severity,
            'action' => $action,
            'model_type' => 'permit',
            'model_id' => $permit->id ?? null
        ]);
    }

    /**
     * Alias for notifyPermitAction to match PermitController usage
     */
    public static function notifyComplianceAction($action, $permit, $user = null)
    {
        return self::notifyPermitAction($action, $permit, $user);
    }

    /**
     * Send notification for obligation/corrective action actions
     */
    public static function notifyObligationAction($action, $obligation, $user = null)
    {
        $severity = 'medium';
        if (isset($obligation->priority) && $obligation->priority === 'Critical')
            $severity = 'high';
        if ($action === 'overdue')
            $severity = 'critical';

        self::broadcastNotification([
            'title' => 'Obligation ' . ucfirst($action),
            'message' => "Obligation '{$obligation->title}' has been {$action}",
            'type' => $severity === 'critical' ? 'error' : ($severity === 'high' ? 'warning' : 'info'),
            'category' => 'permit', // Group with permits/compliance
            'severity' => $severity,
            'action' => $action,
            'model_type' => 'corrective_action',
            'model_id' => $obligation->id
        ]);
    }

    /**
     * Send notification for risk flags
     */
    public static function notifyRiskFlag($data)
    {
        self::broadcastNotification([
            'title' => 'High Risk Flag',
            'message' => $data['message'] ?? 'A new risk factor has been identified.',
            'type' => 'error',
            'category' => 'risk',
            'severity' => 'critical',
            'action' => 'flagged',
            'model_type' => $data['model_type'] ?? 'risk',
            'model_id' => $data['model_id'] ?? null
        ]);
    }

    /**
     * Send notification for audit log actions
     */
    public static function notifyAuditAction($action, $message, $user = null)
    {
        self::broadcastNotification([
            'title' => 'Audit: ' . ucfirst($action),
            'message' => $message,
            'type' => 'info',
            'category' => 'system',
            'severity' => 'low',
            'action' => $action,
            'model_type' => 'audit',
            'model_id' => null
        ]);
    }

    /**
     * Send external event notification
     */
    public static function notifyExternalEvent($source, $message, $type = 'info')
    {
        self::broadcastNotification([
            'title' => 'External: ' . ucfirst($source),
            'message' => $message,
            'type' => $type,
            'category' => 'system',
            'severity' => 'medium',
            'action' => 'external_event',
            'model_type' => 'integration',
            'model_id' => null
        ]);
    }

    /**
     * Send notification for template actions
     */
    public static function notifyTemplateAction($action, $template, $user = null)
    {
        self::broadcastNotification([
            'title' => 'Template ' . ucfirst($action),
            'message' => "Legal Template '{$template->name}' has been {$action}",
            'type' => 'info',
            'category' => 'template',
            'severity' => 'medium',
            'action' => $action,
            'model_type' => 'template',
            'model_id' => $template->id
        ]);
    }

    /**
     * Send notification for clause actions
     */
    public static function notifyClauseAction($action, $clause, $user = null)
    {
        self::broadcastNotification([
            'title' => 'Clause ' . ucfirst($action),
            'message' => "Legal Clause '{$clause->title}' has been {$action}",
            'type' => 'info',
            'category' => 'clause',
            'severity' => 'medium',
            'action' => $action,
            'model_type' => 'clause',
            'model_id' => $clause->id
        ]);
    }

    /**
     * Send notification for AI analysis actions
     */
    public static function notifyAiAnalysisAction($action, $result, $user = null)
    {
        $riskLevel = $result->risk_level ?? 'low';
        $severity = $riskLevel === 'high' || $riskLevel === 'critical' ? 'high' : 'medium';
        $type = $severity === 'high' ? 'warning' : 'info';

        $docTitle = $result->ai_result['title'] ?? 'Document';

        self::broadcastNotification([
            'title' => 'AI Analysis ' . ucfirst($action),
            'message' => "AI Analysis for '{$docTitle}' is {$action}. Risk level: " . strtoupper($riskLevel),
            'type' => $type,
            'category' => 'ai_analysis',
            'severity' => $severity,
            'action' => $action,
            'model_type' => 'ai_analysis',
            'model_id' => $result->id
        ]);
    }

    /**
     * Send notification for integration/webhook actions
     */
    public static function notifyIntegrationAction($source, $message, $type = 'info')
    {
        self::broadcastNotification([
            'title' => 'Sync: ' . ucfirst($source),
            'message' => $message,
            'type' => $type,
            'category' => 'integration',
            'severity' => 'medium',
            'action' => 'sync',
            'model_type' => 'integration',
            'model_id' => null
        ]);
    }

    /**
     * General broadcast helper
     */
    public static function broadcastNotification(array $data)
    {
        try {
            $recipients = self::getRecipients();
            \Log::info("Broadcasting notification '{$data['title']}' to " . $recipients->count() . " recipients.");
            foreach ($recipients as $recipient) {
                \Log::debug("Notifying recipient: " . ($recipient->employee_name ?? $recipient->name) . " (Role: {$recipient->role})");
                $recipient->notify(new SystemActionNotification($data));
            }
        } catch (\Exception $e) {
            \Log::error('SystemNotificationService Error: ' . $e->getMessage());
        }
    }

    /**
     * Get users to notify (Owner + relevant staff)
     */
    protected static function getRecipients()
    {
        // For the Soliera Executive dashboard, we notify all department accounts
        // and any User with Owner/Executive/Admin/Visitor-related roles
        $deptAccounts = DeptAccount::all();
        $users = \App\Models\User::whereIn('role', [
            'Owner',
            'Executive',
            'Admin Manager',
            'Front Office Manager',
            'Security Supervisor',
            'HR Manager',
            'Administrator',
            'Admin'
        ])->get();
        return $deptAccounts->concat($users);
    }

    // Keep legacy methods for backward compatibility with existing controller calls
    public static function notifyFacilityReservationAction($action, $data, $user = null)
    {
        $facilityName = isset($data->facility) ? $data->facility->name : 'Unknown Facility';
        self::broadcastNotification([
            'title' => ucfirst($action) . ' Facility',
            'message' => "Facility '{$facilityName}' has been {$action}",
            'type' => 'info',
            'category' => 'facility',
            'severity' => 'medium',
            'action' => $action,
            'model_type' => 'facility_reservation',
            'model_id' => $data->id ?? null
        ]);
    }

    public static function notifyFolderAction($action, $folder, $user = null)
    {
        self::broadcastNotification([
            'title' => ucfirst($action) . ' Folder',
            'message' => "Folder '{$folder->name}' has been {$action}",
            'type' => $action === 'deleted' ? 'error' : 'info',
            'category' => 'folder',
            'severity' => $action === 'deleted' ? 'high' : 'medium',
            'action' => $action,
            'model_type' => 'document',
            'model_id' => $folder->id
        ]);
    }

    public static function notifyLegalCaseAction($action, $data, $user = null)
    {
        $caseTitle = isset($data->case_title) ? $data->case_title : 'Unknown Case';
        $severity = 'medium';
        if ($action === 'created' || $action === 'urgent')
            $severity = 'high';

        self::broadcastNotification([
            'title' => ucfirst($action) . ' Legal Case',
            'message' => "Legal case '{$caseTitle}' has been {$action}",
            'type' => $severity === 'high' ? 'warning' : 'info',
            'category' => 'legal',
            'severity' => $severity,
            'action' => $action,
            'model_type' => 'legal_case',
            'model_id' => $data->id ?? null
        ]);
    }

    public static function notifyVisitorIncidentAction($action, $data, $user = null)
    {
        $incidentTitle = isset($data->title) ? $data->title : 'Unknown Incident';
        self::broadcastNotification([
            'title' => ucfirst($action) . ' Incident',
            'message' => "Security incident '{$incidentTitle}' has been {$action}",
            'type' => 'error',
            'category' => 'risk',
            'severity' => 'high',
            'action' => $action,
            'model_type' => 'visitor_incident',
            'model_id' => $data->id ?? null
        ]);
    }

    /**
     * Universal notification method for ad-hoc alerts
     */
    public static function notifyUniversal($data)
    {
        self::broadcastNotification([
            'title' => $data['title'] ?? 'System Alert',
            'message' => $data['message'] ?? 'Action performed',
            'type' => $data['type'] ?? 'info',
            'category' => $data['category'] ?? 'general',
            'severity' => $data['severity'] ?? 'medium',
            'action' => $data['action'] ?? 'performed',
            'model_type' => $data['model_type'] ?? null,
            'model_id' => $data['model_id'] ?? null
        ]);
    }
}
