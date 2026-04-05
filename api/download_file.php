<?php
if (!isset($_GET['url'])) {
    http_response_code(400);
        exit('Invalid request');
        }

        $url = $_GET['url'];

        /* =====================
           AMBIL HEADER SAJA
           ===================== */
           $ch = curl_init($url);
           curl_setopt_array($ch, [
               CURLOPT_NOBODY => true,
                   CURLOPT_FOLLOWLOCATION => true,
                       CURLOPT_RETURNTRANSFER => true,
                           CURLOPT_SSL_VERIFYPEER => false,
                               CURLOPT_SSL_VERIFYHOST => false,
                                   CURLOPT_USERAGENT => "Mozilla/5.0"
                                   ]);
                                   $headers = curl_exec($ch);
                                   curl_close($ch);

                                   /* =====================
                                      TENTUKAN NAMA FILE ASLI
                                      ===================== */
                                      $filename = null;

                                      /* 1️⃣ Dari Content-Disposition */
                                      if (preg_match('/filename="?([^"]+)"?/i', $headers, $m)) {
                                          $filename = $m[1];
                                          }

                                          /* 2️⃣ Dari URL */
                                          if (!$filename) {
                                              $path = parse_url($url, PHP_URL_PATH);
                                                  $filename = basename($path);
                                                  }

                                                  /* Fallback */
                                                  if (!$filename || !strpos($filename, '.')) {
                                                      $filename = 'pinterest-download';
                                                      }

                                                      /* =====================
                                                         STREAM FILE
                                                         ===================== */
                                                         $ch = curl_init($url);
                                                         curl_setopt_array($ch, [
                                                             CURLOPT_FOLLOWLOCATION => true,
                                                                 CURLOPT_RETURNTRANSFER => false,
                                                                     CURLOPT_SSL_VERIFYPEER => false,
                                                                         CURLOPT_SSL_VERIFYHOST => false,
                                                                             CURLOPT_USERAGENT => "Mozilla/5.0"
                                                                             ]);

                                                                             header("Content-Type: application/octet-stream");
                                                                             header("Content-Disposition: attachment; filename=\"$filename\"");
                                                                             header("Cache-Control: no-store");
                                                                             header("Pragma: no-cache");

                                                                             curl_exec($ch);
                                                                             curl_close($ch);
                                                                             exit;