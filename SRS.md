# Document Management System (DMS)

## Software Requirement Specification (SRS)

**Project Name:** DMS – Document Management System

**Prepared For:** Management / Client Presentation

**Prepared By:** Rahul Sharma

**Technology Stack:**

- Backend: Laravel
- Frontend: HTML, Bootstrap, jQuery, AJAX
- Database: MySQL
- Authentication: Laravel Authentication & Middleware
- Server: Apache / Nginx

---

## 1. Project Overview

The Document Management System (DMS) is a web-based application designed to manage scanned documents, metadata indexing, verification workflows, and department-level approvals.

The system will support:

- Document digitization
- Index management
- Metadata management
- Verification workflow
- Department approval
- Reporting system
- User role management

The application will maintain secure access based on user roles and permissions.

---

## 2. User Roles

The system will contain 5 types of users:

| Role | Description |
|------|-------------|
| User | General user who can search/view properties |
| Operator | Creates indexes and uploads scanned documents |
| Checker | Verifies index and metadata |
| Department Head | Final QC verification |
| Admin | Full system control |

---

## 3. Functional Requirements

### 3.1 USER MODULE

**User Features**

- User Registration
- User Login
- View Profile
- Search Properties using Filters
- Change Password
- Logout

**Property Search Filters**

User can search property using:

- State
- District
- Vault Registration Office
- Volume Year
- Book Number
- Volume Number
- Deed Number
- Presentation Year

### 3.2 OPERATOR MODULE

**Operator Authentication**

- Operator cannot self-register
- Operator account will be created by Admin

**Operator Dashboard Menus**

1. Index Creation
    - Create Index
    - Edit Index
    - Delete Index
    - View Index List

**Index Fields**

- State
- District
- Vault Registration Office
- Volume Year
- Book No.
- Volume No.
- Is Volume Forwarded (Yes/No)

2. Upload Scanned Document
    - Upload scanned document
    - Edit uploaded document
    - Delete uploaded document
    - View document list

Supported formats:

- PDF
- JPG
- PNG
- TIFF

3. Bulk Scanned Document Upload

Operator can upload multiple scanned documents together.

Features:

- ZIP Upload
- Bulk PDF Upload
- Bulk Image Upload

4. Metadata Creation

Operator can add metadata for deeds.

**Metadata Fields:**

- Presentation Year
- Deed Number
- Party Name
- Property Details
- Village
- Area
- Registration Date

**Reports**

- Report 1
- Report 2

**Additional Features**

- Change Password
- Logout

### 3.3 CHECKER MODULE

**Checker Authentication**

- Checker cannot register
- Checker account created by Admin

**Checker Dashboard Menus**

1. Index Verification
    - Checker verifies index details, volume details, registration details
    - Actions: Approve, Reject, Send Back

2. Metadata Agency Verification
    - Checker verifies metadata entered by operator
    - Actions: Approve, Reject

3. Metadata QC Verification
    - Checker performs quality check verification
    - Actions: QC Pass, QC Fail

**Important Business Rule**

- Once an Index is verified by Checker:
    - Operator cannot modify that Index
    - Operator cannot delete related records
- System should lock the verified data.

**Reports**

- Report 1
- Report 2

**Additional Features**

- Change Password
- Logout

### 3.4 DEPARTMENT HEAD MODULE

**Department Head Authentication**

- No self-registration
- Added by Admin only

**Department Head Dashboard**

- Metadata QC Verification (Volume Wise)

Department Head can:

- Verify complete volume
- Approve volume
- Reject volume
- Return for correction

Verification done volume-wise.

**Reports**

- Report 1
- Report 2

**Additional Features**

- Change Password
- Logout

### 3.5 ADMIN MODULE

**Admin Features**

Admin has full system access.

Admin can:

- Manage all users
- View all reports
- Manage masters
- Monitor workflow
- Access all modules

---

## 4. MASTER MODULES

### 4.1 State Master

Fields:

- State Name
- State Code
- Status

Operations:

- Create
- Edit
- Delete
- List

### 4.2 District Master

Fields:

- State ID (Foreign Key)
- District Name
- District Code

Operations:

- Create
- Edit
- Delete
- List

### 4.3 Vault Registration Office Master

Fields:

- District ID (Foreign Key)
- Office Name
- Office Code
- Address

Operations:

- Create
- Edit
- Delete
- List

---

## 5. INDEX MANAGEMENT FLOW

1. Create Index
    - Operator/Admin creates Index.
    - Fields: District, Vault Registration Office, Volume Year, Book Number, Volume Number, Is Volume Forwarded

2. Checker Verification
    - Checker verifies Index.
    - Status Types: Pending, Approved, Rejected, Sent Back
    - After approval: Record becomes locked for Operator

3. Add Multiple Property Deeds
    - Each Index can contain multiple deeds.
    - Fields: Presentation Year, Deed Number
    - Relationship: One Index → Many Deeds

4. Upload Scanned Documents
    - Operator uploads scanned files for deeds.
    - Features: Single Upload, Bulk Upload, Multi-file Support

5. Metadata Entry
    - Operator enters metadata for each deed.

6. Metadata Verification
    - Checker verifies metadata.

7. Department Head QC Verification
    - Department Head verifies complete volume.

---

## 6. WORKFLOW DIAGRAM

Operator Creates Index
        ↓
Checker Verifies Index
        ↓
Operator Adds Deeds
        ↓
Operator Uploads Scanned Documents
        ↓
Operator Adds Metadata
        ↓
Checker Verifies Metadata
        ↓
Department Head Final QC Verification
        ↓
Completed

---

## 7. DATABASE DESIGN (MAIN TABLES)

| Table Name | Purpose |
|------------|---------|
| users | All users |
| roles | User roles |
| states | State master |
| districts | District master |
| vault_registration_offices | Registration office master |
| indexes | Main volume/index records |
| deeds | Multiple deeds under index |
| scanned_documents | Uploaded scanned files |
| metadata | Metadata records |
| index_verifications | Checker verification |
| metadata_verifications | Metadata verification |
| qc_verifications | Department QC verification |
| activity_logs | System logs |
| reports | Reporting data |

---

## 8. SECURITY FEATURES

- Role Based Access Control (RBAC)
- Password Encryption
- Middleware Protection
- Session Management
- File Access Security
- Audit Logs
- Data Locking after Verification

---

## 9. REPORTS

**Operator Reports**

- Daily work report
- Upload status report

**Checker Reports**

- Pending verification report
- QC report

**Department Head Reports**

- Volume-wise verification report

**Admin Reports**

- User activity report
- System summary report
- Verification status report

---

## 10. NON-FUNCTIONAL REQUIREMENTS

| Requirement | Description |
|-------------|-------------|
| Performance | Fast document upload and search |
| Security | Secure authentication and authorization |
| Scalability | Can handle large document volume |
| Availability | 24×7 availability |
| Backup | Database and file backup |
| Maintainability | Modular code structure |

---

## 11. RECOMMENDED TECHNICAL ARCHITECTURE

- Backend: Laravel
- Frontend: Bootstrap
- Frontend Scripts: jQuery, AJAX
- Database: MySQL
- File Storage: Local Storage / Cloud Storage
- Authentication: Laravel Middleware & Guards

---

## 12. FUTURE ENHANCEMENTS

- Digital Signature
- OCR Integration
- AI-based Metadata Detection
- API Integration
- Mobile App
- Barcode/QR Integration
- Document Expiry Alerts

---

## 13. CONCLUSION

The proposed DMS application will provide:

- Secure document management
- Efficient indexing workflow
- Multi-level verification
- Role-based access
- Centralized document storage
- Complete audit and reporting system

The system will reduce manual paperwork and improve document tracking, monitoring, and verification efficiency across departments.
