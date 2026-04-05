<?php
if (!isset($_POST['url'])) die("URL tidak valid");
$url = trim($_POST['url']);

function clean_filename($text) {
    $text = html_entity_decode($text, ENT_QUOTES);
        $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
            $text = preg_replace('/\s+/', '-', trim($text));
                return strtolower(substr($text, 0, 60));
                }

                /* FETCH HTML */
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                  CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                          CURLOPT_USERAGENT => "Mozilla/5.0"
                          ]);
                          $html = curl_exec($ch);
                          curl_close($ch);
                          if (!$html) die("Gagal mengambil halaman");

                          /* TITLE */
                          $title = 'pinterest-media';
                          if (preg_match('/property="og:title" content="([^"]+)"/', $html, $t)) {
                            $title = clean_filename($t[1]);
                            }
                            $date = date('Y-m-d');

                            /* HEADER HTML */
                            echo "<!DOCTYPE html>
                            <html lang='id'>
                            <head>
                            <meta charset='UTF-8'>
                            <title>Hasil Download</title>
                            <meta name='viewport' content='width=device-width, initial-scale=1'>
                            <link rel='stylesheet' href='style.css'>
                            </head>
                            <body>
                            <header class='header'><div class='logo'>⬇ PIN DL</div></header>
                            <main class='container'>
                            <h2 class='result-title'>Hasil Download</h2>";

                            /* ===== DETECT VIDEO ===== */
                            $mp4 = null;
                            if (preg_match('/\"contentUrl\":\"([^\"]+\.mp4[^\"]*)\"/', $html, $m)) {
                              $mp4 = str_replace('\\u002F','/',$m[1]);
                              }
                              if (!$mp4 && preg_match('/\"video_list\":\{(.*?)\}\}/s', $html, $b)) {
                                preg_match_all('/\"url\":\"([^\"]+\.mp4[^\"]*)\"/', $b[0], $u);
                                  if (!empty($u[1])) $mp4 = str_replace('\\u002F','/',end($u[1]));
                                  }

                                  if ($mp4) {
                                    $filename = "pinterest-video-$title-$date.mp4";
                                      echo "
                                        <div class='result-card'>
                                            <h3>🎥 Video Siap Diunduh</h3>
                                                <div class='result-media'><video controls src='$mp4'></video></div>
                                                    <a class='download-btn'
                                                           href='download_file.php?url=".urlencode($mp4)."&name=".urlencode($filename)."'>
                                                                  ⬇ Download MP4
                                                                      </a>
                                                                          <a class='download-btn secondary' href='index.php'>Download Lainnya</a>
                                                                            </div>
                                                                              </main><footer class='footer'>© 2026 Pinterest Downloader</footer></body></html>";
                                                                                exit;
                                                                                }

                                                                                /* ===== DETECT IMAGE ===== */
                                                                                $image = null;
                                                                                if (preg_match('/property=\"og:image\" content=\"([^\"]+)\"/', $html, $i)) {
                                                                                  $image = str_replace('\\u002F','/',$i[1]);
                                                                                  }
                                                                                  if ($image) {
                                                                                    $ext = pathinfo(parse_url($image, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                                                                                      $filename = "pinterest-image-$title-$date.$ext";
                                                                                        echo "
                                                                                          <div class='result-card'>
                                                                                              <h3>🖼 Gambar Siap Diunduh</h3>
                                                                                                  <div class='result-media'><img src='$image'></div>
                                                                                                      <a class='download-btn'
                                                                                                             href='download_file.php?url=".urlencode($image)."&name=".urlencode($filename)."'>
                                                                                                                    ⬇ Download Gambar
                                                                                                                        </a>
                                                                                                                            <a class='download-btn secondary' href='index.php'>Download Lainnya</a>
                                                                                                                              </div>
                                                                                                                                </main><footer class='footer'>© 2026 Pinterest Downloader</footer></body></html>";
                                                                                                                                  exit;
                                                                                                                                  }

                                                                                                                                  echo "<div class='result-card'><h3>❌ Media tidak ditemukan</h3>
                                                                                                                                  <a class='download-btn secondary' href='index.php'>Kembali</a></div>
                                                                                                                                  </main><footer class='footer'>© 2026 Pinterest Downloader</footer></body></html>";