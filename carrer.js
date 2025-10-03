// Remove localStorage and use backend for jobs
const jobsContainer = document.getElementById('jobs-container');
const jobSearch = document.getElementById('job-search');
const searchBtn = document.getElementById('search-btn');

 
        function initScrollAnimations() {
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    animateElements.forEach(element => {
        gsap.fromTo(element, 
            { opacity: 0, y: 30 },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            }
        );
    });
}
 
// Render job cards
function renderJobs(jobsArray) {
    jobsContainer.innerHTML = '';
    if (!Array.isArray(jobsArray) || jobsArray.length === 0) {
        jobsContainer.innerHTML = '<p class="no-jobs">No jobs found.</p>';
        return;
    }
    jobsArray.forEach(job => {
        const department = job.department || '';
        const location = job.location || '';
        const type = job.type || '';
        const salary = job.salary || '';
        const description = job.description || '';
        const tagsArray = Array.isArray(job.tags) ? job.tags : (job.tags ? String(job.tags).split(',').map(tag => tag.trim()) : []);
        const jobCard = document.createElement('div');
        jobCard.className = 'job-card';
        jobCard.innerHTML = `
            <div class="job-info">
                <h3>${job.title || ''}</h3>
                <div class="job-meta">
                    <span><i class="fas fa-building"></i> ${department}</span>
                    <span><i class="fas fa-map-marker-alt"></i> ${location}</span>
                    <span><i class="fas fa-clock"></i> ${type}</span>
                    <span><i class="fas fa-indian-rupee-sign"></i> ${salary}</span>
                </div>
                <div class="job-tags">
                    ${tagsArray.map(tag => `<span class="job-tag">${tag}</span>`).join('')}
                </div>
                <p class="job-desc">${description}</p>
            </div>
            <a href="contact.html" class="job-apply-btn">Apply Now <i class="fas fa-arrow-right"></i></a>
        `;
        jobsContainer.appendChild(jobCard);
    });
}

// Fetch jobs from backend and render
async function fetchAndRenderJobs() {
    try {
        const res = await fetch('server/admin/admin-get-jobs.php');
        const data = await res.json();
        if (data.status && Array.isArray(data.response)) {
            renderJobs(data.response);
        } else {
            jobsContainer.innerHTML = '<p class="no-jobs">No jobs found.</p>';
        }
    } catch (err) {
        jobsContainer.innerHTML = '<p class="no-jobs">Failed to load jobs.</p>';
    }
}


window.addEventListener("DOMContentLoaded", fetchAndRenderJobs);    
// Search functionality (searches all jobs from backend)
searchBtn?.addEventListener('click', searchJobs);
jobSearch?.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') searchJobs();
});

async function searchJobs() {
    const term = jobSearch.value.toLowerCase();
    try {
        const res = await fetch('server/admin/admin-get-jobs.php');
        const data = await res.json();
        if (data.status && Array.isArray(data.response)) {
            const filtered = data.response.filter(job =>
                (job.title && job.title.toLowerCase().includes(term)) ||
                (job.department && job.department.toLowerCase().includes(term)) ||
                (job.description && job.description.toLowerCase().includes(term)) ||
                (job.tags && String(job.tags).toLowerCase().includes(term))
            );
            renderJobs(filtered);
        } else {
            jobsContainer.innerHTML = '<p class="no-jobs">No jobs found.</p>';
        }
    } catch (err) {
        jobsContainer.innerHTML = '<p class="no-jobs">Failed to load jobs.</p>';
    }
}

// Make job card clickable
window.addEventListener('click', (e) => {
    const card = e.target.closest('.job-card');
    if (card && !e.target.classList.contains('job-apply-btn')) {
        card.querySelector('.job-apply-btn')?.click();
    }
});
