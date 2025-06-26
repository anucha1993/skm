<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer - {{ $fileName }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .header {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 1.5em;
        }
        .header .actions {
            margin-top: 10px;
        }
        .header .actions a {
            display: inline-block;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        .header .actions a:hover {
            background: #0056b3;
        }
        .pdf-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .pdf-controls {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .pdf-canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }
        .pdf-content {
            padding: 20px;
            text-align: center;
        }
        button {
            margin: 0 5px;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background: #0056b3;
        }
        button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        .page-info {
            margin: 0 15px;
            font-weight: bold;
            font-size: 16px;
        }
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .error {
            text-align: center;
            padding: 40px;
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $fileName }}</h1>
        <div class="actions">
            <a href="{{ route('labours.list-files.download', $listFile) }}" target="_blank">
                📥 Download PDF
            </a>
            <a href="{{ asset("storage/{$listFile->file_path}") }}" target="_blank">
                🔗 Open in New Tab
            </a>
            <a href="javascript:history.back()">
                ← Back
            </a>
        </div>
    </div>

    <div class="pdf-container">
        <div class="pdf-controls">
            <button id="prevPage">⬅ Previous</button>
            <span class="page-info">
                Page <span id="pageNum">1</span> of <span id="pageCount">--</span>
            </span>
            <button id="nextPage">Next ➡</button>
            <button id="zoomOut">🔍−</button>
            <button id="zoomIn">🔍+</button>
            <button id="fitWidth">Fit Width</button>
        </div>
        <div class="pdf-content">
            <div class="loading" id="loading">Loading PDF...</div>
            <canvas id="pdfCanvas" class="pdf-canvas" style="display: none;"></canvas>
            <div class="error" id="error" style="display: none;">
                Error loading PDF. Please try downloading the file instead.
            </div>
        </div>
    </div>

    <script>
        // PDF.js configuration
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        let scale = 1.0;
        const canvas = document.getElementById('pdfCanvas');
        const ctx = canvas.getContext('2d');

        // แสดง PDF
        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                    updateButtons();
                });
            });

            document.getElementById('pageNum').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function updateButtons() {
            document.getElementById('prevPage').disabled = pageNum <= 1;
            document.getElementById('nextPage').disabled = pageNum >= pdfDoc.numPages;
        }

        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }

        function onZoomIn() {
            scale += 0.2;
            queueRenderPage(pageNum);
        }

        function onZoomOut() {
            if (scale > 0.3) {
                scale -= 0.2;
                queueRenderPage(pageNum);
            }
        }

        function fitWidth() {
            // คำนวณ scale เพื่อให้พอดีกับความกว้างของ container
            if (pdfDoc) {
                pdfDoc.getPage(pageNum).then(function(page) {
                    const containerWidth = document.querySelector('.pdf-content').clientWidth - 40;
                    const viewport = page.getViewport({ scale: 1.0 });
                    scale = containerWidth / viewport.width;
                    queueRenderPage(pageNum);
                });
            }
        }

        // Event listeners
        document.getElementById('prevPage').addEventListener('click', onPrevPage);
        document.getElementById('nextPage').addEventListener('click', onNextPage);
        document.getElementById('zoomIn').addEventListener('click', onZoomIn);
        document.getElementById('zoomOut').addEventListener('click', onZoomOut);
        document.getElementById('fitWidth').addEventListener('click', fitWidth);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'ArrowLeft':
                    onPrevPage();
                    break;
                case 'ArrowRight':
                    onNextPage();
                    break;
                case '+':
                case '=':
                    onZoomIn();
                    break;
                case '-':
                    onZoomOut();
                    break;
            }
        });

        // โหลด PDF
        const url = '{{ $pdfUrl }}';

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('pageCount').textContent = pdfDoc.numPages;
            document.getElementById('loading').style.display = 'none';
            document.getElementById('pdfCanvas').style.display = 'block';

            // แสดงหน้าแรก
            renderPage(pageNum);
            updateButtons();

            // Auto fit width on load
            setTimeout(fitWidth, 100);

        }).catch(function(error) {
            console.error('Error loading PDF:', error);
            document.getElementById('loading').style.display = 'none';
            document.getElementById('error').style.display = 'block';
        });
    </script>
</body>
</html>
