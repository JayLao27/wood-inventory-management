# User Roles & Access Control

## Available Roles

The system now has role-based access control with the following user types:

### 1. Admin
- **Email:** admin@rmwoodworks.com
- **Password:** admin123
- **Access:** Full access to all subsystems

### 2. Inventory Clerk
- **Email:** inventory@rmwoodworks.com
- **Password:** inventory123
- **Access:** Inventory subsystem only

### 3. Procurement Officer
- **Email:** procurement@rmwoodworks.com
- **Password:** procurement123
- **Access:** Procurement subsystem only

### 4. Workshop Staff
- **Email:** workshop@rmwoodworks.com
- **Password:** workshop123
- **Access:** Production subsystem only

### 5. Sales Clerk
- **Email:** sales@rmwoodworks.com
- **Password:** sales123
- **Access:** Sales and Orders subsystem, Customer management

### 6. Accounting Staff
- **Email:** accounting@rmwoodworks.com
- **Password:** accounting123
- **Access:** Accounting subsystem, Dashboard

## Access Permissions

| Subsystem | Admin | Inventory Clerk | Procurement Officer | Workshop Staff | Sales Clerk | Accounting Staff |
|-----------|-------|----------------|---------------------|----------------|-------------|------------------|
| Dashboard | ✓ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Inventory | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ |
| Procurement | ✓ | ✗ | ✓ | ✗ | ✗ | ✗ |
| Production | ✓ | ✗ | ✗ | ✓ | ✗ | ✗ |
| Sales & Orders | ✓ | ✗ | ✗ | ✗ | ✓ | ✗ |
| Accounting | ✓ | ✗ | ✗ | ✗ | ✗ | ✓ |
| Customers | ✓ | ✗ | ✗ | ✗ | ✓ | ✗ |
| Profile | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |

## How It Works

When a user tries to access a page they don't have permission for, they will receive a **403 Unauthorized** error message.

Each user can only see and interact with the subsystems relevant to their role.
