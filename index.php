<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark glass-card mb-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-address-book me-2"></i>Contact Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <!-- <li class="nav-item"> commented by me
                        <a class="nav-link" href="#" onclick="showAddModal()">
                            <i class="fas fa-plus me-1"></i>Add Contact
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-number" id="totalContacts">0</div>
                    <div class="text-muted">Total Contacts</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-success" id="activeContacts">0</div>
                    <div class="text-muted">Active Contacts</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-warning" id="pendingContacts">0</div>
                    <div class="text-muted">Pending Updates</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="stats-number text-info" id="recentContacts">0</div>
                    <div class="text-muted">Added This Week</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchInput"
                        placeholder="Search contacts by name, email, or phone...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" onclick="showAddModal()">
                    <i class="fas fa-plus me-2"></i>Add New Contact
                </button>
            </div>
        </div>

        <!-- Contacts Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contactsTableBody">
                        <!-- Sample data - will be populated by PHP -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Contact</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contactForm">
                        <input type="hidden" id="contactId" name="contactId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label required">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                                <div class="invalid-feedback">Please enter a valid name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactNumber" class="form-label required">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" required>
                                <div class="invalid-feedback">Please enter a valid contact number.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label required">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                <div class="invalid-feedback">Please enter a valid address.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveContact()">
                        <i class="fas fa-save me-2"></i>Save Contact
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Contact Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 text-center mb-3">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Full Name:</strong></div>
                        <div class="col-8" id="viewFullName"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-8" id="viewEmail"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Phone:</strong></div>
                        <div class="col-8" id="viewPhone"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Address:</strong></div>
                        <div class="col-8" id="viewAddress"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Status:</strong></div>
                        <div class="col-8" id="viewStatus"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Created:</strong></div>
                        <div class="col-8" id="viewCreated"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-check-circle text-success me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="successMessage">
                Operation completed successfully!
            </div>
        </div>

        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="errorMessage">
                An error occurred. Please try again.
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script.js"></script>
</body>

</html>