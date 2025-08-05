// Tab Navigation Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            console.log('Tab clicked:', tab.getAttribute('data-tab'));
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.remove('active'));
            
            // Add active class to clicked tab
            tab.classList.add('active');
            
            // Show corresponding content
            const tabId = tab.getAttribute('data-tab');
            console.log('Activating tab content:', tabId);
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Enhanced validation and modal feedback for request form
    const requestForm = document.getElementById('requestForm');
    if (requestForm) {
        requestForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            // Clear previous error messages
            const errorMessages = requestForm.querySelectorAll('.error-message');
            errorMessages.forEach(em => em.textContent = '');
            // Collect form data
            const formData = {
                firstName: requestForm.firstName.value.trim(),
                lastName: requestForm.lastName.value.trim(),
                email: requestForm.email.value.trim(),
                phone: requestForm.phone.value.trim(),
                serviceType: requestForm.serviceType.value,
                startDate: requestForm.startDate.value,
                endDate: requestForm.endDate.value,
                requirements: requestForm.requirements ? requestForm.requirements.value.trim() : ''
            };
            // Validation
            let valid = true;
            if (!formData.firstName) {
                requestForm.firstName.nextElementSibling.textContent = 'First name is required';
                valid = false;
            }
            if (!formData.lastName) {
                requestForm.lastName.nextElementSibling.textContent = 'Last name is required';
                valid = false;
            }
            if (!formData.email || !/^\S+@\S+\.\S+$/.test(formData.email)) {
                requestForm.email.nextElementSibling.textContent = 'Valid email is required';
                valid = false;
            }
            if (!formData.phone || !/^\d{10,15}$/.test(formData.phone)) {
                requestForm.phone.nextElementSibling.textContent = 'Enter a valid phone number';
                valid = false;
            }
            if (!formData.serviceType) {
                requestForm.serviceType.nextElementSibling.textContent = 'Please select a service';
                valid = false;
            }
            if (!formData.startDate) {
                requestForm.startDate.nextElementSibling.textContent = 'Start date is required';
                valid = false;
            }
            if (!formData.endDate) {
                requestForm.endDate.nextElementSibling.textContent = 'End date is required';
                valid = false;
            }
            if (!valid) return;
            // Simulate AJAX submission (replace with real API if needed)
            try {
                // Uncomment below for real API
                // const response = await fetch('http://localhost:3001/api/requests', {
                //     method: 'POST',
                //     headers: { 'Content-Type': 'application/json' },
                //     body: JSON.stringify(formData)
                // });
                // const result = await response.json();
                // if (response.ok) {
                //     showRequestSuccessModal();
                //     requestForm.reset();
                // } else {
                //     alert('Error: ' + (result.error || 'Failed to submit request'));
                // }
                showRequestSuccessModal();
                requestForm.reset();
            } catch (error) {
                alert('Network error: ' + error.message);
            }
        });
    }
    function showRequestSuccessModal() {
        const modal = document.getElementById('requestSuccessModal');
        modal.style.display = 'block';
    }
    document.getElementById('closeRequestSuccess').onclick = () => {
        document.getElementById('requestSuccessModal').style.display = 'none';
    };
    window.onclick = event => {
        const modal = document.getElementById('requestSuccessModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Feedback form submission handler
    const feedbackForm = document.getElementById('feedbackForm');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Clear previous error messages
            const errorMessages = feedbackForm.querySelectorAll('.error-message');
            errorMessages.forEach(em => em.textContent = '');

            // Collect form data
            const feedbackData = {
                name: feedbackForm.feedbackName.value.trim(),
                email: feedbackForm.feedbackEmail.value.trim(),
                message: feedbackForm.feedbackMessage.value.trim()
            };

            // Basic client-side validation
            let valid = true;
            if (!feedbackData.name) {
                feedbackForm.feedbackName.nextElementSibling.textContent = 'Name is required';
                valid = false;
            }
            if (!feedbackData.email) {
                feedbackForm.feedbackEmail.nextElementSibling.textContent = 'Email is required';
                valid = false;
            }
            if (!feedbackData.message) {
                feedbackForm.feedbackMessage.nextElementSibling.textContent = 'Message is required';
                valid = false;
            }
            if (!valid) return;

            // For now, just show an alert (backend integration can be added later)
            alert('Thank you for your feedback, ' + feedbackData.name + '!');

            feedbackForm.reset();
        });
    }

    // Explore Our Services button click handler
    const exploreBtn = document.getElementById('exploreServicesBtn');
    if (exploreBtn) {
        exploreBtn.addEventListener('click', () => {
            // Simulate click on Services tab
            const servicesTab = document.querySelector('.tab[data-tab="services"]');
            if (servicesTab) {
                servicesTab.click();
            }
        });
    }
    
    // Service details data structure
    const services = [
        {
            id: 'catering',
            name: 'Catering',
            description: 'Professional catering services for all event sizes, with customizable menus.',
            photos: [
                'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 'decoration',
            name: 'Decoration',
            description: 'Creative decoration services to make your event memorable.',
            photos: [
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80'
            ]
        },
        {
            id: 'photography',
            name: 'Photography',
            description: 'Capture every moment with our expert photography team.',
            photos: [
                'https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80'
            ]
        }
    ];

    // Modal logic for service details
    function showServiceModal(service) {
        const modal = document.getElementById('serviceModal');
        modal.querySelector('.modal-title').textContent = service.name;
        modal.querySelector('.modal-description').textContent = service.description;
        const photosContainer = modal.querySelector('.modal-photos');
        photosContainer.innerHTML = '';
        service.photos.forEach(photo => {
            const img = document.createElement('img');
            img.src = photo;
            img.alt = service.name + ' sample';
            img.className = 'modal-photo';
            photosContainer.appendChild(img);
        });
        modal.style.display = 'block';
    }

    // Add click event listeners to service cards
    window.addEventListener('DOMContentLoaded', () => {
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.addEventListener('click', () => {
                const serviceId = card.getAttribute('data-service-id');
                const service = services.find(s => s.id === serviceId);
                if (service) {
                    showServiceModal(service);
                }
            });
        });
        document.getElementById('closeModal').onclick = () => {
            document.getElementById('serviceModal').style.display = 'none';
        };
        window.onclick = event => {
            const modal = document.getElementById('serviceModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    });
});

// Add animation to elements when they come into view
document.addEventListener('scroll', function() {
    const elements = document.querySelectorAll('.service-card, .review-card, .contact-card, .manager-card');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        
        if (elementPosition < screenPosition) {
            element.style.animationPlayState = 'running';
        }
    });
});

// Initialize animations
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.service-card, .review-card, .contact-card, .manager-card');
    
    animatedElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
    });
});
