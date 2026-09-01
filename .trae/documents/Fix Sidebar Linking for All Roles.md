I will fix the sidebar linking by adding dedicated sections for missing roles (Administrator, Compliance Lead, Security Supervisor, Receptionist) and ensuring all links correspond to valid routes defined in `web.php`.

**Step 1: Update `resources/views/partials/sidebarr.blade.php`**
I will modify the role-based logic to include specific navigation blocks for:
- **Administrator / Super Admin:**
    - Add comprehensive access to all modules: `Dashboard`, `HR`, `Financials`, `Hotel`, `Restaurant`, `Inventory`, `Reporting`, `Settings`, `System Services`.
    - Link to `superadmin.dashboard` where applicable.
- **Compliance Lead / DPO:**
    - Add a "Compliance Workspace" section.
    - Links: `compliance.permits`, `compliance.renewals`, `compliance.evidence`, `compliance.corrective_actions`, `compliance.ai.insights`.
- **Security Supervisor:**
    - Add "Security Operations" section.
    - Links: `visitors.check_in_form`, `visitors.badges`, `visitors.incidents`, `visitors.zones`, `facilities.calendar.view`.
- **Receptionist / Front Office Manager:**
    - Add "Front Desk" section.
    - Links: `visitors.pre_registrations`, `visitors.check_in_form`, `visitors.check_out_form`, `visitors.badges`, `front-office.guest-profiles`.
- **Owner / Director:**
    - Ensure `Audit Logs` (`executive.audit_logs`) and `Audit Packs` (`executive.audit_packs`) are visible.

**Step 2: Verification**
- I will ensure that the `RolePermissionService` normalization works with these role strings (it does, based on my analysis).
- I will double-check that all used route names exist in `routes/web.php`.
