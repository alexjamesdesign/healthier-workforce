<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Secure Link Transformer</title>
    <style>
        :root {
            --primary: #004666;
            /* Client Blue */
            --primary-hover: #00334d;
            --bg: #fdf4dc;
            /* Client Cream */
            --card-bg: #ffffff;
            --text-main: #004666;
            /* Client Blue */
            --text-muted: #536b78;
            --border: #e2e8f0;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-top: 4vh;
            text-align: center;
            /* Center logo and headers */
        }

        .logo {
            max-width: 250px;
            margin-bottom: 2rem;
            display: inline-block;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
            color: var(--primary);
        }

        p.subtitle {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .input-group {
            margin-bottom: 2rem;
            text-align: left;
            /* Keep input labels left-aligned */
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--text-main);
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 0.95rem;
            resize: vertical;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            background-color: #fafafa;
            color: #333;
            /* Keep input text readable/standard */
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 70, 102, 0.1);
            background-color: #fff;
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 70, 102, 0.2);
        }

        button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(0, 70, 102, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        #output-area {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border);
            display: none;
            text-align: left;
            /* Keep results left-aligned */
        }

        #output-area.visible {
            display: block;
        }

        .output-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .output-heading h2 {
            font-size: 1.25rem;
            margin: 0;
            color: var(--primary);
        }

        .result-list {
            display: grid;
            gap: 1rem;
        }

        .result-item {
            display: block;
            padding: 1rem;
            background-color: #f1f5f9;
            border-radius: 8px;
            border: 1px solid var(--border);
            color: var(--primary);
            text-decoration: none;
            word-break: break-all;
            transition: background-color 0.2s, border-color 0.2s;
            font-size: 0.95rem;
        }

        .result-item:hover {
            background-color: #e2e8f0;
            border-color: #cbd5e1;
            text-decoration: underline;
        }

        .empty-state {
            color: var(--text-muted);
            text-align: center;
            padding: 2rem;
            background: #f8fafc;
            border-radius: var(--radius);
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="https://www.healthier-workforce.co.uk/wp-content/themes/healthier-workforce/_static/images/logo.svg"
            alt="Healthier Workforce" class="logo">
        <h1>Healthier Workforce - Secure Link Transformer</h1>
        <p class="subtitle">Paste HTML from your spreadsheet below to generate secure download links.</p>

        <div class="input-group">
            <label for="htmlInput">Input HTML</label>
            <textarea id="htmlInput" placeholder='Example: <a href="https://...">Screenshot.png</a>...'></textarea>
        </div>

        <button id="transformBtn">Transform Links</button>

        <div id="output-area">
            <div class="output-heading">
                <h2>Transformed Links</h2>
            </div>
            <div id="results" class="result-list"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('htmlInput');
            const btn = document.getElementById('transformBtn');
            const outputArea = document.getElementById('output-area');
            const results = document.getElementById('results');

            const SEARCH_PREFIX = 'https://www.healthier-workforce.co.uk/wp-content/uploads/';
            const REPLACE_PREFIX = 'https://www.healthier-workforce.co.uk/wp-admin/admin-post.php?action=hwf_nf_dl&rel=';

            btn.addEventListener('click', () => {
                const rawHtml = input.value;

                if (!rawHtml.trim()) {
                    alert('Please enter some HTML content first.');
                    return;
                }

                // Parse HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(rawHtml, 'text/html');
                const anchors = doc.querySelectorAll('a');

                if (anchors.length === 0) {
                    results.innerHTML = '<div class="empty-state">No links found in the input.</div>';
                    outputArea.classList.add('visible');
                    return;
                }

                // Clear previous results
                results.innerHTML = '';

                let count = 0;
                anchors.forEach(anchor => {
                    const href = anchor.getAttribute('href');
                    let newHref = href;

                    // Transform if it matches the prefix
                    if (href && href.startsWith(SEARCH_PREFIX)) {
                        // Extract the part after the prefix
                        const relativePath = href.substring(SEARCH_PREFIX.length);
                        newHref = REPLACE_PREFIX + relativePath;
                        count++;
                    }

                    // Create clean link element
                    const link = document.createElement('a');
                    link.href = newHref;
                    link.className = 'result-item';
                    link.target = '_blank'; // Maintain new tab behavior
                    link.textContent = anchor.textContent || newHref;

                    results.appendChild(link);
                });

                outputArea.classList.add('visible');
            });
        });
    </script>

</body>

</html>