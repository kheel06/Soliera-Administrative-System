# implementation.md — Soliera Administrative Management System Revision (Laravel)
> Add-on: This section defines **(1) submodule → route links**, **(2) page content per role/submodule**, and **(3) UI components** (cards, matrix, graphs, tables, pagination, tabs) for each page.  
> Use these specs to build the full UI and ensure **role-accurate content**.

---

## A) Route & Page Linking Map (Submodule → URL → Controller → View)
> Naming convention:
- Prefix by module: `/executive`, `/legal`, `/compliance`, `/facilities`, `/vault`, `/visitors`, `/reports`, `/settings`
- Use RESTful routes + extra routes for approvals/actions.
- Every list page uses pagination + filters.

### A1) Executive (Owner/Director)
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Governance Overview | `/executive/overview` | `ExecutiveController@overview` | `executive/overview.blade.php` |
| Risk & Compliance Snapshot | `/executive/risk` | `ExecutiveController@risk` | `executive/risk.blade.php` |
| Approvals (High-Value/High-Risk) | `/executive/approvals` | `ExecutiveApprovalController@index` | `executive/approvals/index.blade.php` |
| Contracts Register (Exec) | `/executive/legal/contracts` | `ExecutiveContractController@index` | `executive/legal/contracts/index.blade.php` |
| Cases & Disputes (Exec) | `/executive/legal/cases` | `ExecutiveCaseController@index` | `executive/legal/cases/index.blade.php` |
| Permit Status Board | `/executive/compliance/permits` | `ExecutivePermitController@board` | `executive/compliance/permits/board.blade.php` |
| Renewals Calendar | `/executive/compliance/renewals` | `ExecutivePermitController@calendar` | `executive/compliance/renewals/calendar.blade.php` |
| Evidence Vault | `/executive/compliance/evidence` | `ExecutiveEvidenceController@index` | `executive/compliance/evidence/index.blade.php` |
| Booking Calendar (view) | `/executive/facilities/calendar` | `ExecutiveFacilitiesController@calendar` | `executive/facilities/calendar.blade.php` |
| Policy Approvals (Gov) | `/executive/vault/policy-approvals` | `ExecutiveVaultController@policyApprovals` | `executive/vault/policy_approvals.blade.php` |
| Retention Overview | `/executive/vault/retention` | `ExecutiveVaultController@retentionOverview` | `executive/vault/retention_overview.blade.php` |
| Sensitive Visits Log | `/executive/visitors/sensitive` | `ExecutiveVisitorController@sensitiveLog` | `executive/visitors/sensitive.blade.php` |
| Incident Escalations | `/executive/visitors/escalations` | `ExecutiveVisitorController@escalations` | `executive/visitors/escalations.blade.php` |
| KPI Dashboard | `/executive/reports/kpis` | `ExecutiveReportsController@kpis` | `executive/reports/kpis.blade.php` |
| Audit Trail Viewer | `/executive/reports/audit-logs` | `AuditLogController@index` | `reports/audit_logs/index.blade.php` |
| Export Audit Packs | `/executive/reports/audit-packs` | `AuditPackController@index` | `reports/audit_packs/index.blade.php` |
| Role Access Overview | `/executive/settings/rbac-view` | `RbacController@overviewReadOnly` | `settings/rbac/overview_readonly.blade.php` |
| AI Configuration | `/executive/settings/ai-view` | `AiSettingsController@readOnly` | `settings/ai/read_only.blade.php` |
| Master Data | `/executive/settings/master-view` | `MasterDataController@readOnly` | `settings/master/read_only.blade.php` |

---

### A2) Legal (Legal Officer + GM + Admin Doc; Owner read-only)
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Contract Requests (CRF Inbox / Track) | `/legal/contract-requests` | `ContractRequestController@index` | `legal/contract_requests/index.blade.php` |
| Create Contract Request | `/legal/contract-requests/create` | `ContractRequestController@create` | `legal/contract_requests/create_modal.blade.php` |
| Contracts Workspace | `/legal/contracts` | `ContractController@index` | `legal/contracts/index.blade.php` |
| Contract Details (tabs) | `/legal/contracts/{id}` | `ContractController@show` | `legal/contracts/show.blade.php` |
| Upload Version | `/legal/contracts/{id}/versions` | `ContractVersionController@store` | modal |
| Approvals Queue | `/legal/approvals` | `ApprovalController@index` | `legal/approvals/index.blade.php` |
| Contract Register | `/legal/contract-register` | `ContractRegisterController@index` | `legal/register/index.blade.php` |
| Obligations & Renewals | `/legal/obligations` | `ContractObligationController@index` | `legal/obligations/index.blade.php` |
| Alerts | `/legal/alerts` | `LegalAlertController@index` | `legal/alerts/index.blade.php` |
| Templates Library | `/legal/templates` | `TemplateController@index` | `legal/templates/index.blade.php` |
| Clause Library | `/legal/clauses` | `ClauseLibraryController@index` | `legal/clauses/index.blade.php` |
| Cases Register | `/legal/cases` | `CaseController@index` | `legal/cases/index.blade.php` |
| Case Timeline | `/legal/cases/{id}` | `CaseController@show` | `legal/cases/show.blade.php` |
| AI Legal Insights | `/legal/ai/insights` | `AiLegalController@index` | `legal/ai/insights.blade.php` |

---

### A3) Compliance (Compliance Lead + Admin Doc + GM; Owner read-only)
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Permit Matrix | `/compliance/permits` | `PermitController@index` | `compliance/permits/index.blade.php` |
| Renewals Planner | `/compliance/renewals` | `PermitController@renewals` | `compliance/renewals/index.blade.php` |
| Requirements Checklist | `/compliance/permits/{id}/requirements` | `PermitRequirementController@index` | `compliance/requirements/index.blade.php` |
| Evidence Vault | `/compliance/evidence` | `PermitFileController@index` | `compliance/evidence/index.blade.php` |
| AI Compliance Insights | `/compliance/ai/insights` | `AiComplianceController@index` | `compliance/ai/insights.blade.php` |
| Corrective Actions Tracker | `/compliance/corrective-actions` | `CorrectiveActionController@index` | `compliance/corrective_actions/index.blade.php` |

---

### A4) Facilities (Admin Doc + GM + Security view)
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Booking Calendar | `/facilities/calendar` | `ReservationController@calendar` | `facilities/calendar.blade.php` |
| New Reservation Request | `/facilities/reservations/create` | `ReservationController@create` | `facilities/reservations/create_modal.blade.php` |
| Reservations List | `/facilities/reservations` | `ReservationController@index` | `facilities/reservations/index.blade.php` |
| Reservation Details (tabs) | `/facilities/reservations/{id}` | `ReservationController@show` | `facilities/reservations/show.blade.php` |
| Setup & Close-out Reports | `/facilities/post-use` | `PostUseController@index` | `facilities/post_use/index.blade.php` |
| Resources Catalog | `/facilities/resources` | `ResourceController@index` | `facilities/resources/index.blade.php` |
| Reservation Approvals | `/facilities/approvals` | `FacilitiesApprovalController@index` | `facilities/approvals/index.blade.php` |

---

### A5) Vault (Document Management)
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Folder Library | `/vault/folders` | `FolderController@index` | `vault/folders/index.blade.php` |
| Documents Index | `/vault/documents` | `DocumentController@index` | `vault/documents/index.blade.php` |
| Document Details (tabs) | `/vault/documents/{id}` | `DocumentController@show` | `vault/documents/show.blade.php` |
| Controlled Documents | `/vault/controlled` | `ControlledDocController@index` | `vault/controlled/index.blade.php` |
| Versions & Obsolete Archive | `/vault/versions` | `DocumentVersionController@index` | `vault/versions/index.blade.php` |
| Retention & Disposal Queue | `/vault/retention` | `RetentionController@index` | `vault/retention/index.blade.php` |
| Access Matrix | `/vault/access-matrix` | `AccessMatrixController@index` | `vault/access_matrix/index.blade.php` |

---

### A6) Visitors
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| Visitor Pre-Registration | `/visitors/pre-registrations` | `PreRegistrationController@index` | `visitors/pre_registrations/index.blade.php` |
| Walk-in Check-in | `/visitors/check-in` | `VisitorLogController@checkInForm` | `visitors/check_in.blade.php` |
| Check-out & Badge Return | `/visitors/check-out` | `VisitorLogController@checkOutForm` | `visitors/check_out.blade.php` |
| Badge / Pass Log | `/visitors/badges` | `VisitorLogController@badges` | `visitors/badges.blade.php` |
| Allowed Zones & Escort Rules | `/visitors/zones` | `ZonePolicyController@index` | `visitors/zones/index.blade.php` |
| Visitor Incidents | `/visitors/incidents` | `VisitorIncidentController@index` | `visitors/incidents/index.blade.php` |

---

### A7) Reports & Audit
| Submodule | Route | Controller@method | View |
|---|---|---|---|
| KPI Dashboard | `/reports/kpis` | `KpiController@index` | `reports/kpis/index.blade.php` |
| Audit Trail Viewer | `/reports/audit-logs` | `AuditLogController@index` | `reports/audit_logs/index.blade.php` |
| Audit Pack Builder | `/reports/audit-packs` | `AuditPackController@index` | `reports/audit_packs/index.blade.php` |

---

## B) Standard Page UI Kit (Use everywhere)
### B1) Cards
Use 4 KPI cards on top of every dashboard page:
- Card title
- Big number
- Small trend text
- Icon badge (gold accent)

### B2) Charts (Graphs)
- Use a single chart component per page section:
  - Line chart (trend)
  - Bar chart (comparison)
  - Donut chart (distribution)
- Always include:
  - date range filter (Today / 7D / 30D / Custom)
  - legend
  - empty-state message

### B3) Tables
Every list page table must have:
- Search input (debounced)
- Filters (status, date range, type)
- Column sort
- Pagination (Laravel paginator)
- Row actions dropdown: View / Edit / Archive / Delete (role-based)

### B4) Tabs (Details pages)
Details pages must use tabs:
- Overview
- Files / Versions
- Approvals / Timeline
- AI Insights (if available)
- Audit Trail (read-only)

### B5) Centered Modals
All create/edit forms:
- Centered modal
- 2-column layout on desktop
- footer: Cancel (neutral) + Save (blueish)

---

## C) Page Content Specs (Per Role + Submodule)

# C1) OWNER/DIRECTOR — Pages & Content

## C1.1 Executive Dashboard → Governance Overview (`/executive/overview`)
**Top KPI Cards (4)**
- Active Contracts
- Contracts Expiring (30 days)
- Permits For Renewal
- Open High-Risk Cases

**Graphs**
- Line: Compliance status trend (permits active/for renewal/expired)
- Bar: Contracts by risk level (Low/Med/High)
- Donut: Document classifications distribution (Internal/Confidential/etc.)

**Tables**
- “High-Risk Approvals Pending” (paginated)
  - entity, counterparty, value, risk, age, action (View)
- “Recent Audit Events (Sensitive)” (paginated)
  - user, action, module, timestamp

**Filters**
- Date range picker (default 30D)
- Risk filter (High only default)

---

## C1.2 Risk & Compliance Snapshot (`/executive/risk`)
**Cards (4)**
- Total compliance score (computed)
- Open corrective actions
- Visitor incidents (30D)
- Documents disposed (30D)

**Matrix**
- Compliance Matrix Table:
  - Permit category vs status (Active/For Renewal/Expired)
  - clickable cells go to permit list

**Graphs**
- Bar: Renewal deadlines by month
- Donut: Incidents severity distribution

---

## C1.3 Approvals (High-Value/High-Risk) (`/executive/approvals`)
**Tabs**
- Contract Approvals
- Policy Approvals
- Exceptions (Facilities/Access)

**Table**
- Approvals list (paginated)
  - entity_type, entity_title, requested_by, recommended_by (Legal), risk, value, status
  - actions: View, Approve, Reject (Owner only)

---

## C1.4 Legal Governance Desk
### Contracts Register (Exec) (`/executive/legal/contracts`)
**Cards**
- Active contracts
- Expiring in 90 days
- New contracts (30D)
- High-risk active

**Table**
- Contracts (paginated)
  - Contract ID, Counterparty, Type, Value, Expiry, Risk, Status
  - action: View only

### Cases & Disputes (Exec) (`/executive/legal/cases`)
**Table**
- Case no, type, risk, status, opened, owner, latest activity
- action: View only

### AI Legal Insights (Summary) (`/executive/legal/ai-summary`)
**Cards**
- Avg risk score
- Top deviations count
- Contracts flagged (High)
- AI runs (30D)

**Table**
- flagged items with reason + link

---

## C1.5 Compliance & Permits Center
### Permit Status Board (`/executive/compliance/permits`)
**Kanban board**
- Active
- For Renewal
- Expired
Card shows: permit, renewal date, owner, days left

### Renewals Calendar (`/executive/compliance/renewals`)
- Month calendar
- Click day → drawer shows permits due

### Evidence Vault (`/executive/compliance/evidence`)
- Table: permit, file count, last upload date
- View only downloads allowed by policy

---

## C1.6 Corporate Document Vault
### Repository (Read-only) (`/executive/vault/repository`)
- folder tree left, documents table right
- View only

### Policy Approvals (Governance) (`/executive/vault/policy-approvals`)
- Tabs: Pending / Approved / Rejected
- Approve/reject only for governance-level docs

### Retention Overview (`/executive/vault/retention`)
- Cards: disposal due, disposed (30D), overdue, sensitive backlog
- Table: overdue retention items

---

## C1.7 Visitor & Security Oversight
### Sensitive Visits Log (`/executive/visitors/sensitive`)
- Table: visitor, company, purpose, host, zones, check-in/out, incident flag
- View only

### Incident Escalations (`/executive/visitors/escalations`)
- Table: incident time, severity, description (short), resolved?, assigned
- View only

---

## C1.8 Reports & Audit Center (Owner)
### KPI Dashboard (`/executive/reports/kpis`)
- Tabs: Legal / Compliance / Facilities / Vault / Visitors
- Each tab shows 4 cards + 1 chart + 1 top issues table

### Audit Trail Viewer (`/reports/audit-logs`)
- Filters: module/entity_type, action, user, date
- Table paginated
- Export CSV (Owner/GM only)

### Export Audit Packs (`/reports/audit-packs`)
- Create pack modal (centered):
  - date range, modules, include files? (zip), sensitivity rules
- Table: generated packs + download

---

# C2) GM — Pages & Content (Operational)
> Same page templates but GM has **action** on operational approvals and exception workflows.

## C2.1 Operations Dashboard (`/dashboard` for GM)
**Cards**
- Pending approvals (GM)
- Facilities exceptions
- Permits due within 30 days
- Visitor incidents today

**Graphs**
- Line: approvals completed per week
- Bar: facilities utilization by resource

**Tables**
- Approvals Inbox (GM)
- Today’s Exceptions

---

## C2.2 Legal Operations Desk
### Contract Requests (CRF Inbox) (`/legal/contract-requests`)
**Table**
- CRF No, Counterparty, Type, Value, Status, Needed by, Assigned Legal
- actions: View, Assign, Move Status (GM/Legal/Admin Doc)

### Contracts Workspace (GM View) (`/legal/contracts`)
**Tabs**
- Active
- For Approval (GM)
- Expiring Soon
- High Risk (read)

**Table**
- add quick filter: value range

### Contract Approvals (Low/Normal) (`/legal/approvals?scope=gm`)
- table of approvals
- actions: Approve/Reject within GM threshold

### Cases & Claims (Ops View) (`/legal/cases`)
- view + assign + escalate to Owner

### Obligations & Renewals (`/legal/obligations`)
- table: obligation, due, owner, status
- GM can reassign owners and request proof

---

## C2.3 Compliance & Permits Center
### Permit Matrix (View/Action) (`/compliance/permits`)
- table paginated; GM can comment + escalate

### Renewals Planner (`/compliance/renewals`)
- month + list
- GM sees top 10 due soon

### Evidence Vault (View) (`/compliance/evidence`)
- view files by permit; download allowed

---

## C2.4 Resource Booking Control
### Booking Calendar (`/facilities/calendar`)
- month/week toggle
- click event → modal shows details and actions

### Reservation Approvals (Special Cases) (`/facilities/approvals`)
- table: after-hours/public/function hall/vehicle
- actions: approve/reject

---

## C2.5 Document Vault (GM)
### Policy Approvals (Operational) (`/vault/controlled?tab=approvals`)
- tabs: Pending Review / Pending GM Approval / Approved
- GM can approve operational policies only

### Controlled Docs Releases (View) (`/vault/controlled`)
- view list and download

---

## C2.6 Visitor & Access Monitor
### VIP / Sensitive Notifications (`/visitors/vip`)
- cards: today’s VIP, restricted zone entries
- table: logs

### Visitor Logs (View) (`/visitors/logs`)
- filters: date, host, company
- view only

### Incident Reports (View) (`/visitors/incidents`)
- table + severity badges

---

# C3) Admin Manager / Document Controller — Pages & Content (Core Admin)
## C3.1 Admin Dashboard (`/dashboard` for Admin Doc)
**Cards**
- Contracts expiring 30/60/90
- Permits due
- Documents pending review
- Disposal overdue

**Graphs**
- Line: uploads per week (vault)
- Bar: reservations per resource

**Tables**
- “Missing Evidence” (permits missing required files)
- “Unindexed Files” (uploads without tags)

---

## C3.2 Legal Records Desk
### Contract Requests (Create & Track) (`/legal/contract-requests`)
- can create CRF via centered modal
- table: CRF list with statuses

### Contracts Archive (Metadata + Final Files) (`/legal/contracts?tab=archive`)
- table: Signed/Archived contracts
- bulk metadata editor (tags, classification)

### Contract Register (IDs & Indexing) (`/legal/contract-register`)
- register table + export CSV
- actions: assign contract ID, link to document vault record

### Obligations Tracker (Alerts + Proof) (`/legal/obligations`)
- table + “Request Proof” action (creates notification + audit log)

### Renewals & Expiry Alerts (`/legal/alerts`)
- calendar + list
- actions: mark addressed, notify GM/Legal

---

## C3.3 Compliance & Permits Desk
### Permit Matrix (`/compliance/permits`)
- CRUD permits
- assign owners/backups
- status auto updates

### Evidence Vault (Upload & Index) (`/compliance/evidence`)
- upload modal centered
- index required docs checklist (checkboxes)

---

## C3.4 Resource Booking Desk
### Reservations List (`/facilities/reservations`)
- validate conflicts
- confirmation QR/booking code output
- pagination + search

### Setup & Close-out Reports (`/facilities/post-use`)
- table: reservation, overtime, damage, incident
- actions: create post-use report

### Resources Catalog (`/facilities/resources`)
- full CRUD
- include is_active toggle

---

## C3.5 Document Vault (Core)
### Folder Library (`/vault/folders`)
- left tree + right folder table
- create folder modal centered
- rename/move folder (restricted: cannot move locked folders)

### Documents Index (`/vault/documents`)
- table: doc_no, title, type, status, classification, version, owner
- actions: view/edit/upload new version/submit for review/archive

### Controlled Documents (Publish Workflow) (`/vault/controlled`)
- tabs: Draft / For Review / Approved / Obsolete
- workflow buttons based on role (Admin Doc publishes)

### Retention & Disposal Queue (`/vault/retention`)
- table: doc, due date, policy, classification
- actions: mark disposed (creates audit record)

### Access Matrix (`/vault/access-matrix`)
- table: document → roles → permissions
- role toggles (view/download/edit)

---

## C3.6 Visitor Coordination Desk
### Visitor Pre-Registration (`/visitors/pre-registrations`)
- create prereg modal
- table: planned visitors
- action: convert to walk-in log

### Visitor Logs (View per policy) (`/visitors/logs`)
- Admin Doc can view for archiving + retention tagging only

### Incident Attachments (`/visitors/incidents`)
- upload attachments to vault/incident folder

---

# C4) Legal Officer — Pages & Content (Legal Work)
## C4.1 Legal Dashboard (`/legal/dashboard`)
**Cards**
- Pending triage
- Drafts awaiting redline
- Approvals awaiting recommendation
- High-risk flagged by AI

**Graphs**
- Line: contract cycle time trend
- Bar: deviations count by template

**Tables**
- Review Queue (paginated)

---

## C4.2 Contracts Workspace (`/legal/contracts/{id}`)
**Tabs**
- Overview (party, dates, value, risk)
- Versions (upload + compare)
- Approvals (timeline)
- Obligations (suggest + confirm)
- AI Insights (risk + clauses + deviations)
- Audit Trail

**Overview Cards**
- Risk Level badge
- Value
- Expiry countdown
- Status

---

## C4.3 Legal Templates & Clauses
### Templates Library (`/legal/templates`)
- CRUD templates
- preview panel (right side)

### Clause Library (`/legal/clauses`)
- CRUD clauses
- filter by category
- insert clause to contract (optional button)

---

## C4.4 Cases & Disputes Desk
### Case Details (`/legal/cases/{id}`)
**Tabs**
- Summary
- Timeline Events (add event modal)
- Evidence Files
- Decisions/Actions
- Audit Trail

---

## C4.5 AI Legal Insights (`/legal/ai/insights`)
**Filters**
- date, contract type, risk score >= x

**Table**
- entity, classification, risk score, top issues, link

---

# C5) Compliance Lead / DPO — Pages & Content (Compliance)
## C5.1 Compliance Dashboard (`/compliance/dashboard`)
**Cards**
- For renewal (30D)
- Expired permits
- Disposal due (30D)
- Visitor log retention due

**Graphs**
- Line: renewals closed per month
- Donut: classification distribution on vault

**Tables**
- “Renewals Due” (paginated)
- “Disposal Due” (paginated)

---

## C5.2 Privacy & Retention Control
### Retention Policies (`/settings/retention-policies`)
- CRUD retention policies
- validation: retention_months >= 1

### Access Review (`/vault/access-matrix?filter=sensitive`)
- list sensitive docs
- quick review toggles

---

## C5.3 Visitor Privacy Desk
### Visitor Logs (Policy View) (`/visitors/logs?mode=privacy`)
- columns hide sensitive fields
- retention countdown column

---

# C6) Security Supervisor — Pages & Content (Security)
## C6.1 Security Dashboard (`/security/dashboard`)
**Cards**
- Active visitors
- Expected visitors today
- Incidents today
- Badges unreturned

**Tables**
- Active visitors list (real-time refresh optional)

---

## C6.2 Visitor Checkpoint
### Walk-in Check-in (`/visitors/check-in`)
- centered modal form style but as page card
- fields: name, company, purpose, host, allowed zones, badge no, check-in time
- “Print badge pass” button (optional)

### Check-out & Badge Return (`/visitors/check-out`)
- quick search: visit_no or visitor name
- action: check-out + badge return

### Visitor Incidents (`/visitors/incidents`)
- CRUD incidents
- severity badges

---

# C7) Front Office Manager — Pages & Content (Limited Admin)
## C7.1 Document Uploads
### Folio Archive Upload (`/vault/documents/create?type=folio`)
- simplified modal
- restricted folder auto-selected

### Daily Summary Upload
- upload + tags + date

---

## D) Pagination Rules (Global)
- Default page size: 10 rows
- Allow user to switch: 10/25/50
- Persist filters in query string

---

## E) Table Column Standards (Global)
- Show: status badges, due countdown chips, risk chips
- Row actions dropdown aligned right
- Sticky header for long lists

---

## F) Dashboard Analytics Data Sources (What to compute)
- Active Contracts: `legal_contracts.status IN ('Active','Signed','For Approval','For Review')`
- Expiring 30 days: `expiry_date BETWEEN today AND today+30`
- Permits for renewal: `compliance_permits.status='For Renewal'`
- Disposal due: retention due calculation based on `approved_at/effective_date + retention_months`

---

## G) Implementation Notes (TRAE Agent Guidance)
- Each page should be built as:
  - Controller fetches role-scoped data
  - Blade renders: cards + charts + table
  - Charts can use Chart.js (recommended)
- Use one `components/table.blade.php` and `components/tabs.blade.php`.
- Ensure every action logs to `audit_logs`.

---
END OF ADDITION