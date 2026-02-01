<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pinterest Downloader</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
  <div class="logo">⬇ PIN DL</div>
  </header>

  <main class="container">
    <h1>Download Video & Gambar Pinterest</h1>
      <p class="subtitle">Cepat • Gratis • Tanpa Watermark</p>

        <form action="download.php" method="post" class="download-box" onsubmit="showLoading()">
            <input type="url" name="url" placeholder="Paste link Pinterest / pin.it" required>
                <button type="submit" id="downloadBtn">Download</button>
                  </form>

                    <div id="loading" class="loading hidden">
                        <div class="spinner"></div>
                            <p>Mengambil media…</p>
                              </div>

                                <div class="note">
                                    By using this service you agree to our Terms of Service.
                                      </div>
                                      </main>

                                      <footer class="footer">© 2026 Pinterest Downloader</footer>

                                      <script>
                                      function showLoading(){
                                        document.getElementById('loading').classList.remove('hidden');
                                          document.getElementById('downloadBtn').disabled = true;
                                          }
                                          </script>
                                          </body>
                                          </html>