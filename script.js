// Global variables
let contacts = [];
let currentContactId = null;

// Initialize the application
document.addEventListener("DOMContentLoaded", function () {
  loadContacts();
  updateStats()
  setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
  // Search functionality
  document.getElementById("searchInput").addEventListener("input", function () {
    filterContacts();
  });

  // Filter functionality
  document
    .getElementById("filterStatus")
    .addEventListener("change", function () {
      filterContacts();
    });

  // Form validation
  const form = document.getElementById("contactForm");
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    saveContact();
  });
}

// Load contacts (will be replaced with AJAX call to PHP)
function loadContacts() {
  // This function will make an AJAX call to PHP to load contacts
  // This Code is created by me
  fetch("all.php")
    .then(res => res.json())
    .then(data => {
      contacts = data;
      updateStats();
      updateTable();
    })
    .catch(err => console.log(err));
}

// Update statistics
function updateStats() {
  if(contacts != null){
      const total = contacts.length || 0; // Sample data count
    const active = contacts.filter((c) => c.status === "active").length || 0;
    const pending = contacts.filter((c) => c.status === "pending").length || 0;
    const recent =
      contacts.filter((c) => {
        const created = new Date(c.createdAt);
        const weekAgo = new Date();
        weekAgo.setDate(weekAgo.getDate() - 7);
        return created >= weekAgo;
      }).length || 0;

    document.getElementById("totalContacts").textContent = total;
    document.getElementById("activeContacts").textContent = active;
    document.getElementById("pendingContacts").textContent = pending;
    document.getElementById("recentContacts").textContent = recent;
  }
}

// Show add contact modal
function showAddModal() {
  currentContactId = null;
  document.getElementById("modalTitle").textContent = "Add New Contact";
  document.getElementById("contactForm").reset();

  const modal = new bootstrap.Modal(document.getElementById("contactModal"));
  modal.show();
}

// Show edit contact modal
function showEditModal(id) {
   fetch("single.php",{
    method: "POST",
    headers: {
      "Contect-Type": "application/json" 
    },
    body: JSON.stringify({id})
  })
  .then(res => res.json())
  .then(row => { 
    const contact = {
      id: row['contactId'],
      fullName: row['fullName'],
      email: row['email'],
      contactNumber: row['contactNumber'],
      address: row['address'],
      status: row['status'],
      city: row['city'],
      country: row['country'],
    };

    document.getElementById("modalTitle").textContent = "Edit Contact";
    // Populate form
    document.getElementById("contactId").value = contact.id;
    document.getElementById("fullName").value = contact.fullName;
    document.getElementById("email").value = contact.email;
    document.getElementById("contactNumber").value = contact.contactNumber;
    document.getElementById("address").value = contact.address;
    document.getElementById("status").value = contact.status;
    document.getElementById("city").value = contact.city;
    document.getElementById("country").value = contact.country;

    const modal = new bootstrap.Modal(document.getElementById("contactModal"));
    modal.show();
  }).catch(err => console.log(err));
}

// View contact details
function viewContact(id) {
    console.log(id);
   fetch("single.php",{
    method: "POST",
    headers: {
      "Contect-Type": "application/json" 
    },
    body: JSON.stringify({id})
  })
  .then(res => res.json())
  .then(row => { 
  const contact = {
    fullName: row['contactId'],
    email: row['email'],
    contactNumber: row['contactNumber'],
    address: row['address'],
    status: row['status'],
    createdDate: row['createdAt'],
  };

  // Populate view modal
  document.getElementById("viewFullName").textContent = contact.fullName;
  document.getElementById("viewEmail").textContent = contact.email;
  document.getElementById("viewPhone").textContent = contact.contactNumber;
  document.getElementById("viewAddress").textContent = contact.address;
  document.getElementById(
    "viewStatus"
  ).innerHTML = `<span class="badge bg-success">${contact.status}</span>`;
  document.getElementById("viewCreated").textContent = contact.createdDate;

  const modal = new bootstrap.Modal(document.getElementById("viewModal"));
  modal.show();
  }).catch(err => console.log(err));
}

// Save contact (Create/Update)
function saveContact() {
  const form = document.getElementById("contactForm");

  // Validate form
  if (!form.checkValidity()) {
    form.classList.add("was-validated");
    return;
  }

  // Get form data
  const formData = new FormData(form);
  const contactData = {};
  formData.forEach((value, key) => {
    contactData[key] = value;
  });

  // Simulate AJAX call
  if(contactData['contactId'] == ''){
    fetch("insert.php", {
      method : "POST",
      headers : {
        "Content-Type" : "application/json",
      },
      body: JSON.stringify(contactData)
    })
    .then(res => res.text())
    .then(msg => {
      console.log(msg);
    }).catch(err => console.log(err));
  } else {
    fetch("update.php", {
      method : "POST",
      headers : {
        "Content-Type" : "application/json",
      },
      body: JSON.stringify(contactData)
    })
    .then(res => res.text())
    .then(msg => {
      console.log(msg);
    }).catch(err => console.log(err));
  }
  setTimeout(() => {
    showToast(
      "success",
      currentContactId
        ? "Contact updated successfully!"
        : "Contact added successfully!"
    );

    // Close modal
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("contactModal")
    );
    modal.hide();

    // Reset form
    form.reset();
    form.classList.remove("was-validated");

    // Reload contacts
    loadContacts();
    updateStats();
  }, 500);
}

// Delete contact
function deleteContact(id) {
  if (confirm("Are you sure you want to delete this contact?")) {
    // This code is created by me
    fetch("delete.php", {
      method : "POST",
      headers : {
        "Content-Type" : "application/json",
      },
      body: JSON.stringify({id})
    })
    .then(res => res.text())
    .then(msg => {
      console.log(msg);
    }).catch(err => console.log(err));
    setTimeout(() => {
      showToast("success", "Contact deleted successfully!");
      loadContacts();
      updateStats();
    }, 500);
  }
}

// Filter contacts
function filterContacts() {
  const searchTerm = document.getElementById("searchInput").value.toLowerCase();
  const statusFilter = document.getElementById("filterStatus").value;
  const rows = document.querySelectorAll("#contactsTableBody tr");

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    const status = row.querySelector(".badge")?.textContent.toLowerCase() || "";

    const matchesSearch = text.includes(searchTerm);
    const matchesStatus = !statusFilter || status.includes(statusFilter);

    row.style.display = matchesSearch && matchesStatus ? "" : "none";
  });
}

// Update table (will be replaced with dynamic content from PHP)
function updateTable() {
  // This function will be called after AJAX calls to update the table
  // This code is created by me
  let table = document.getElementById("contactsTableBody");
  if(contacts != null){
    let html = "";
    for(contact of contacts){
      html +=`<tr>
                <td>${contact['contactId']}</td>
                <td>${contact['fullName']}</td>
                <td>${contact['email']}</td>
                <td>${contact['contactNumber']}</td>
                <td>${contact['address']}</td>
                <td><span class="badge bg-success">${contact['status']}</span></td>
                <td>${contact['createdAt']}</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm" onclick="showEditModal(${contact['contactId']})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-info btn-sm" onclick="viewContact(${contact['contactId']})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteContact(${contact['contactId']})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
              </tr>`;
    }
    table.innerHTML = html;
  } else {
    table.innerHTML = "<tr><td  style='text-align: center;' colspan=8>No Data Found</td></tr>";
  }
}

// Show toast notification
function showToast(type, message) {
  const toastId = type === "success" ? "successToast" : "errorToast";
  const messageId = type === "success" ? "successMessage" : "errorMessage";

  document.getElementById(messageId).textContent = message;
  const toast = new bootstrap.Toast(document.getElementById(toastId));
  toast.show();
}

// Form validation helpers
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePhone(phone) {
  const re = /^[\d\s\-\+\(\)]+$/;
  return re.test(phone);
}

// Add real-time validation
document.getElementById("email").addEventListener("blur", function () {
  if (this.value && !validateEmail(this.value)) {
    this.classList.add("is-invalid");
  } else {
    this.classList.remove("is-invalid");
  }
});

document.getElementById("contactNumber").addEventListener("blur", function () {
  if (this.value && !validatePhone(this.value)) {
    this.classList.add("is-invalid");
  } else {
    this.classList.remove("is-invalid");
  }
});
