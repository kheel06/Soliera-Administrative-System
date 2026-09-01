I will proceed with the following steps to remove legacy views and update role-based linking:

1.  **Delete Legacy View Directories**:
    -   Delete `resources/views/superadmin/` (Legacy Super Admin module).
    -   Delete `resources/views/admin/` (Unused legacy views).
    -   Delete `resources/views/partials/sidebar-superadmin.blade.php` (Legacy sidebar).

2.  **Update Routes (`routes/web.php`)**:
    -   Remove the "Super Admin Routes" block (lines 1066-1097) which points to the deleted views.
    -   Remove the "Super Admin Analytics" block (lines 544-547).
    -   Remove the `superadmindashboard` route (line 472).
    -   Update the middleware for `integration-sync` (line 550) to allow `Admin Manager` and `Owner` instead of legacy roles (`Administrator`, `Super Admin`).
    -   Ensure all route groups use the new role names (`Admin Manager`, `Owner`, `Legal Officer`, `Compliance Lead`, `Security Supervisor`, `Front Office Manager`).

3.  **Update Sidebar (`resources/views/partials/sidebarr.blade.php`)**:
    -   Change the "Admin Dashboard" link for the **Admin Manager** role from `superadmin.dashboard` to `dashboard` (the modern dashboard).

4.  **Cleanup Controllers & Components**:
    -   **`DashboardController.php`**: Remove the `superAdminDashboard` method.
    -   **`legal-consent.blade.php`**: Remove the reference to `/superadmin/analytics` in the excluded routes list.

This plan removes all "past views" for admin/superadmin and ensures that the **Admin Manager** and other new roles are linked to the correct, modern pages as requested.