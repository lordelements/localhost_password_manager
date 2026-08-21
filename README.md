# VaultKeep 🛡️

> A fully local, self-hosted password manager built with Laravel. Designed for individuals who want complete control over their credential storage without trusting third-party cloud vendors.

---

## 📋 Project Description

VaultKeep is a web-based password manager that runs entirely on your local machine. It stores encrypted credentials in a local database, with **no cloud sync, no third-party authentication, and no internet dependency** after installation. 

---

## 🎯 Objectives

* Provide a secure, self-hosted alternative to commercial cloud password managers.
* Ensure all sensitive data is encrypted at rest and never leaves the local machine.
* Offer a modern, responsive UI comparable to commercial alternatives.
* Demonstrate solid Laravel architecture (MVC, service classes, form requests, Eloquent relationships).
* Build in security best practices from the ground up (encryption, hashing, CSRF/XSS/SQLi protection, auto-lock).

---

## 📦 Scope

### In Scope
* Single-user or multi-user local accounts (registration/login on the same machine).
* Full CRUD for password vault entries with encryption.
* Password generator with strength/entropy analysis.
* Organization via folders, categories, tags, and favorites.
* Import/export capabilities (CSV, encrypted JSON backup).
* Dashboard with vault health metrics.
* Activity logging.
* Configurable settings (theme, auto-logout, generator defaults).

### Out of Scope (For Now)
* Browser extension integration.
* Mobile native applications.
* Cross-device sync.
* Biometric authentication.
* Team or shared vaults.

---

## ⚠️ Limitations

* **Single-machine deployment only:** No built-in synchronization mechanism.
* **Local security dependency:** Security relies on the host machine's physical and OS-level security.
* **No email password recovery:** Recovery must be handled via a locally stored recovery mechanism or manual database intervention.

---

## ⚙️ Requirements

### Functional Requirements
| ID | Requirement Description |
| :--- | :--- |
| **FR1** | Users can register and log in with a hashed master account password. |
| **FR2** | Users can create, read, update, and delete vault entries. |
| **FR3** | Vault entry passwords are encrypted before storage and decrypted only on demand. |
| **FR4** | Users can generate strong passwords with configurable rules. |
| **FR5** | Users can organize entries via folders, categories, tags, and favorites. |
| **FR6** | Users can search and filter vault entries. |
| **FR7** | Users can import and export vault data. |
| **FR8** | Users can view a dashboard summarizing vault health. |
| **FR9** | System logs key account and vault activity. |
| **FR10** | Users can configure application settings (theme, auto-lock timer, etc.). |

### Non-Functional Requirements
| ID | Requirement Description |
| :--- | :--- |
| **NFR1** | Application must run fully offline after installation. |
| **NFR2** | All stored credentials must be encrypted using strong, industry-standard encryption. |
| **NFR3** | Account passwords must be hashed with Argon2id. |
| **NFR4** | UI must be responsive across desktop and tablet screen sizes. |
| **NFR5** | Sessions must auto-lock after a configurable period of inactivity. |
| **NFR6** | Application must protect against CSRF, XSS, and SQL injection. |
| **NFR7** | Codebase must follow Laravel MVC conventions and be maintainable. |

---

## 👤 User Stories

* As a user, I want to register an account so I can access my personal vault.
* As a user, I want to log in securely so only I can see my stored credentials.
* As a user, I want to add a new password entry so I can store my login credentials safely.
* As a user, I want to generate a strong random password so I don't reuse weak passwords.
* As a user, I want to organize entries into folders/tags so I can find them quickly.
* As a user, I want the app to auto-lock after inactivity so my vault isn't exposed if I walk away.
* As a user, I want to export my vault as an encrypted backup so I can restore it later.
* As a user, I want to see a dashboard of weak/duplicate passwords so I can improve my security posture.

---

## 🗺️ Product Backlog & Development Timeline

| Sprint | Focus Area | Estimated Duration |
| :--- | :--- | :--- |
| **Sprint 1** | Project Planning | 1 session |
| **Sprint 2** | System Analysis & Design | 1–2 sessions |
| **Sprint 3** | Project Setup (Laravel, DB, Breeze) | 1 session |
| **Sprint 4** | Authentication | 1–2 sessions |
| **Sprint 5** | Password Vault CRUD | 2–3 sessions |
| **Sprint 6** | Password Generator | 1 session |
| **Sprint 7** | Search & Organization | 1–2 sessions |
| **Sprint 8** | Security Hardening | 2 sessions |
| **Sprint 9** | Import/Export | 1–2 sessions |
| **Sprint 10** | Dashboard | 1–2 sessions |
| **Sprint 11** | Activity Logs | 1 session |
| **Sprint 12** | Settings | 1 session |
| **Sprint 13** | Testing | 2 sessions |
| **Sprint 14** | Documentation | 1 session |

---

## 📌 Sprint 1 Summary

We have successfully defined the project's identity, scope, requirements, user stories, backlog, and timeline. No code has been written yet—this serves as the foundational reference point for the entire project.

*Does this planning document match your vision for VaultKeep? Let me know if you would like to make any adjustments before we move on to **Sprint 2 – System Analysis and Design**!*
