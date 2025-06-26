// JavaScript สำหรับจัดการแสดง PDF แทน thumbnail
document.addEventListener('DOMContentLoaded', function() {
    // หา element ที่แสดงไฟล์ PDF
    const pdfItems = document.querySelectorAll('[data-file-type="pdf"]');
    
    pdfItems.forEach(function(item) {
        const thumbnailImg = item.querySelector('.thumbnail-img');
        const previewUrl = item.dataset.previewUrl;
        const viewUrl = item.dataset.viewUrl;
        
        if (thumbnailImg && previewUrl) {
            // แทนที่ thumbnail image ด้วยปุ่มดู PDF
            const pdfPreview = document.createElement('div');
            pdfPreview.className = 'pdf-preview';
            pdfPreview.innerHTML = `
                <div class="pdf-icon">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4C4 2.89543 4.89543 2 6 2H14L20 8V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V4Z" stroke="#dc2626" stroke-width="2" fill="#fee2e2"/>
                        <path d="M14 2V8H20" stroke="#dc2626" stroke-width="2" fill="none"/>
                        <text x="12" y="16" font-family="Arial, sans-serif" font-size="6" text-anchor="middle" fill="#dc2626">PDF</text>
                    </svg>
                </div>
                <div class="pdf-actions">
                    <button class="btn btn-primary btn-sm view-pdf" data-url="${previewUrl}">
                        👁️ View
                    </button>
                    <button class="btn btn-secondary btn-sm open-pdf" data-url="${viewUrl}">
                        📄 Open
                    </button>
                </div>
            `;
            
            // แทนที่ thumbnail
            thumbnailImg.parentNode.replaceChild(pdfPreview, thumbnailImg);
        }
    });
    
    // Event listener สำหรับปุ่มดู PDF
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-pdf')) {
            e.preventDefault();
            const url = e.target.dataset.url;
            // เปิดใน modal หรือหน้าใหม่
            window.open(url, '_blank', 'width=1000,height=800,scrollbars=yes,resizable=yes');
        }
        
        if (e.target.classList.contains('open-pdf')) {
            e.preventDefault();
            const url = e.target.dataset.url;
            // เปิดใน tab ใหม่
            window.open(url, '_blank');
        }
    });
});

// CSS styles
const style = document.createElement('style');
style.textContent = `
    .pdf-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        min-height: 200px;
        transition: all 0.3s ease;
    }
    
    .pdf-preview:hover {
        background: #e9ecef;
        border-color: #adb5bd;
    }
    
    .pdf-icon {
        margin-bottom: 15px;
    }
    
    .pdf-actions {
        display: flex;
        gap: 10px;
    }
    
    .pdf-actions button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
    }
    
    .pdf-actions .btn-primary {
        background: #007bff;
        color: white;
    }
    
    .pdf-actions .btn-primary:hover {
        background: #0056b3;
    }
    
    .pdf-actions .btn-secondary {
        background: #6c757d;
        color: white;
    }
    
    .pdf-actions .btn-secondary:hover {
        background: #545b62;
    }
`;
document.head.appendChild(style);
