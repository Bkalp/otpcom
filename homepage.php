<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection using JAWSDB credentials from Heroku
$servername = "j1r4n2ztuwm0bhh5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "pus4ul2z8ecrb7xr";  // Your JAWSDB username
$password = "lsgtt5r0qemz08as";  // Your JAWSDB password
$dbname = "fty3z6xrj7wtkeko";    // Your JAWSDB database name
$port = 3306;  // Default MySQL port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Now you are connected to your JAWSDB database!
?>

// Handle form submission for reviews
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $review = $conn->real_escape_string($_POST['review']);
    $rating = (int)$_POST['rating'];

    $sql = "INSERT INTO reviews (name, review, rating) VALUES ('$name', '$review', $rating)";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Review submitted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Load reviews (limit 10 for display)
$limit = 10;
$reviews = [];
$sql = "SELECT name, review, rating FROM reviews ORDER BY id DESC LIMIT $limit";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CipherGuard Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1>CG</h1>
            <span>CipherGuard</span>
        </div>
        <nav>
            <ul>
                <li><a href="javascript:void(0);" onclick="showContent('home')">Home</a></li>
                <li><a href="javascript:void(0);" onclick="showContent('about')">About</a></li>
                <li><a href="javascript:void(0);" onclick="showContent('services')">Services</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div id="home-content" class="content-section">
        <h2>Welcome to CipherGuard, <?php echo $_SESSION['email']; ?>!</h2>
        <p>At CipherGuard, we provide state-of-the-art encryption services designed to protect your most sensitive information. Whether it's text, images, or files, our solutions ensure the confidentiality and integrity of your data.</p>
    </div>

<!-- Social Media Section -->
<div class="social-media-container">
    <a href="https://www.instagram.com" target="_blank" class="social-icon">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
    </a>
    <a href="mailto:example@gmail.com" target="_blank" class="social-icon">
        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7e/Gmail_icon_%282020%29.svg" alt="Gmail">
    </a>
    <a href="https://www.facebook.com" target="_blank" class="social-icon">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook">
    </a>
    <a href="https://www.linkedin.com" target="_blank" class="social-icon">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Linkedin_icon.svg" alt="LinkedIn">
    </a>
</div>


    <div id="about-content" class="content-section" style="display:none;">
        <h2>About CipherGuard</h2>
        <p>CipherGuard is dedicated to delivering high-quality encryption services that empower businesses and individuals to secure their digital assets. We prioritize cutting-edge security protocols, simplicity of use, and an unwavering commitment to protecting your privacy.</p>
        <p>With a team of cybersecurity experts and an intuitive platform, CipherGuard provides top-notch encryption tools that are both accessible and powerful. Our goal is to offer peace of mind, knowing that your information is safe from unauthorized access.</p>
    </div>

    <div id="services-content" class="content-section" style="display:none;">
        <h2>Our Services</h2>
        <p>At CipherGuard, we offer a wide range of encryption services designed to meet your security needs:</p>
        <ul>
            <li><strong>Text Encryption & Decryption:</strong> Encrypt sensitive text data with a click of a button using industry-standard algorithms.</li>
            <li><strong>Image Encryption & Decryption:</strong> Secure your images with advanced encryption techniques to ensure confidentiality and authenticity.</li>
            <li><strong>File Encryption & Decryption:</strong> Protect important files from unauthorized access with robust encryption protocols.</li>
            <li><strong>AES Encryption:</strong> AES (Advanced Encryption Standard) is a global standard for securing data, trusted by organizations worldwide.</li>
        </ul>
    </div>

    <!-- Tools Navigation Section -->
    <section class="tools-navigation">
        <div class="container">
            <ul>
                
                <li><button onclick="showSection('text-tools')">Encrypt Text Online</button></li>
                <li><button onclick="showSection('image-tools')">Encrypt Image Online</button></li>
                <li><button onclick="showSection('file-tools')">Encrypt File Online</button></li>
                <li><button onclick="showSection('video-tools')">Encrypt Video Online</button></li>

            </ul>
        </div>
    </section>

    <!-- Text Encryption & Decryption Section -->
    <section id="text-tools" class="tools" style="display:none;">
        <div class="container">
            <h2>Text Encryption & Decryption</h2>
            <div class="tool-container">
                <div class="encrypt-tool">
                    <h3>Encrypt Text</h3>
                    <textarea id="encryptInputText" placeholder="Enter text to encrypt" rows="5"></textarea>
                    <label><input id="customKeyEncryptCheckboxText" type="checkbox"> Encrypt with a custom key</label>
                    <input id="encryptKeyText" type="text" placeholder="Enter custom key" disabled>
                    <button onclick="encryptText()">Encrypt</button>
                    <textarea id="encryptOutputText" placeholder="Encrypted output" rows="5"></textarea>
                </div>
                <div class="decrypt-tool">
                    <h3>Decrypt Text</h3>
                    <textarea id="decryptInputText" placeholder="Enter text to decrypt" rows="5"></textarea>
                    <label><input id="customKeyDecryptCheckboxText" type="checkbox"> Decrypt with a custom key</label>
                    <input id="decryptKeyText" type="text" placeholder="Enter custom key" disabled>
                    <button onclick="decryptText()">Decrypt</button>
                    <textarea id="decryptOutputText" placeholder="Decrypted output" rows="5"></textarea>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Encryption & Decryption Section -->
    <section id="image-tools" class="tools" style="display:none;">
        <div class="container">
            <h2>Image Encryption & Decryption</h2>
            <div class="tool-container">
                <div class="encrypt-tool">
                    <h3>Encrypt Image</h3>
                    <input type="file" id="imageEncryptInput" accept="image/*">
                    <label><input id="customKeyEncryptCheckboxImage" type="checkbox"> Encrypt with a custom key</label>
                    <input id="encryptKeyImage" type="text" placeholder="Enter custom key" disabled>
                    <button onclick="encryptImage()">Encrypt Image</button>
                    <textarea id="encryptedImageOutput" placeholder="Encrypted output" rows="5"></textarea>
                </div>
                <div class="decrypt-tool">
                    <h3>Decrypt Image</h3>
                    <textarea id="decryptImageInput" placeholder="Enter encrypted text to decrypt" rows="5"></textarea>
                    <label><input id="customKeyDecryptCheckboxImage" type="checkbox"> Decrypt with a custom key</label>
                    <input id="decryptKeyImage" type="text" placeholder="Enter custom key" disabled>
                    <button onclick="decryptImage()">Decrypt Image</button>
                    <img id="decryptedImageOutput" alt="Decrypted Image" style="display:none; width: 100%; margin-top: 15px;">
                </div>
            </div>
        </div>
    </section>

    <!-- File Encryption & Decryption Section -->
    <section id="file-tools" class="tools" style="display:none;">
        <div class="container">
            <h2>File Encryption & Decryption</h2>
            <label for="fileInput">Select a file to encrypt:</label>
            <input type="file" id="fileInput">
            <button id="encryptButton">Encrypt</button>

            <br><br>

            <label for="fileToDecrypt">Select a file to decrypt:</label>
            <input type="file" id="fileToDecrypt">
            <button id="decryptButton">Decrypt</button>

            <br><br>

            <p>Download the decrypted file:</p>
            <a id="downloadLink" style="display:none">Download Decrypted File</a>
        </div>
    </section>
  
   <!-- Video Encryption & Decryption Section -->
    <section id="video-tools" class="tools" style="display:none;">
        <div class="container">
            <h2>Video Encryption & Decryption</h2>
            <label for="videoInput">Select a video to encrypt:</label>
            <input type="file" id="videoInput" accept="video/*">
            <button id="encryptVideoButton">Encrypt Video</button>

            <br><br>
            <label for="videoToDecrypt">Select an encrypted video to decrypt:</label>
            <input type="file" id="videoToDecrypt" accept=".enc">
            <button id="decryptVideoButton">Decrypt Video</button>

            <br><br>
            <p>Download the decrypted video:</p>
            <a id="downloadVideoLink" style="display:none">Download Decrypted Video</a>
        </div>
    </section>
    <!-- Review Section at the Bottom -->
        <div class="review-section" id="reviewSection">
            <h2>User Reviews</h2>

            <div class="review-cards" id="reviewContainer">
                <?php
                if (!empty($reviews)) {
                    foreach ($reviews as $review) {
                        echo '<div class="review-card">';
                        echo '<h4>' . htmlspecialchars($review['name']) . '</h4>';
                        echo '<div class="star-rating">' . str_repeat('★', intval($review['rating'])) . '</div>';
                        echo '<p>' . htmlspecialchars($review['review']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No reviews yet. Be the first to leave one!</p>';
                }
                ?>

            </div>
             <!-- Review Submission Form -->
             <div class="submit-review">
                <h3>Submit Your Review</h3>
                <form method="POST">
                    <input type="text" name="name" placeholder="Your Name (optional)">
                    <select name="rating">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                    <textarea name="review" placeholder="Write your review here..." rows="4" required></textarea>
                    <button type="submit">Submit Review</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CipherGuard. All rights reserved.</p>
    </footer>


    <footer>
        <div class="container">
            <p>&copy; 2024 CipherGuard. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showContent(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            const selectedSection = document.getElementById(`${sectionId}-content`);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }

        function showSection(sectionId) {
            const sections = document.querySelectorAll('.tools');
            sections.forEach(section => {
                section.style.display = (section.id === sectionId) ? 'block' : 'none';
            });
        }

        document.getElementById('customKeyEncryptCheckboxText').addEventListener('change', function() {
            document.getElementById('encryptKeyText').disabled = !this.checked;
        });

        document.getElementById('customKeyDecryptCheckboxText').addEventListener('change', function() {
            document.getElementById('decryptKeyText').disabled = !this.checked;
        });

        document.getElementById('customKeyEncryptCheckboxImage').addEventListener('change', function() {
            document.getElementById('encryptKeyImage').disabled = !this.checked;
        });

        document.getElementById('customKeyDecryptCheckboxImage').addEventListener('change', function() {
            document.getElementById('decryptKeyImage').disabled = !this.checked;
        });

        function encryptText() {
            const text = document.getElementById('encryptInputText').value;
            const key = document.getElementById('encryptKeyText').value || "default_key";
            const encrypted = CryptoJS.AES.encrypt(text, key).toString();
            document.getElementById('encryptOutputText').value = encrypted;
        }

        function decryptText() {
            const encryptedText = document.getElementById('decryptInputText').value;
            const key = document.getElementById('decryptKeyText').value || "default_key";
            try {
                const decrypted = CryptoJS.AES.decrypt(encryptedText, key).toString(CryptoJS.enc.Utf8);
                document.getElementById('decryptOutputText').value = decrypted || "Invalid key!";
            } catch (e) {
                document.getElementById('decryptOutputText').value = "Decryption failed!";
            }
        }

        function encryptImage() {
            const file = document.getElementById('imageEncryptInput').files[0];
            const reader = new FileReader();
            reader.onload = function () {
                const imageData = reader.result;
                const key = document.getElementById('encryptKeyImage').value || 'default_key';
                const encrypted = CryptoJS.AES.encrypt(imageData, key).toString();
                document.getElementById('encryptedImageOutput').value = encrypted;

                const blob = new Blob([encrypted], { type: 'text/plain' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = file.name + '.encr';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
            if (file) reader.readAsDataURL(file);
        }

        function decryptImage() {
            const encryptedText = document.getElementById('decryptImageInput').value;
            const key = document.getElementById('decryptKeyImage').value || 'default_key';
            try {
                const decryptedData = CryptoJS.AES.decrypt(encryptedText, key).toString(CryptoJS.enc.Utf8);
                document.getElementById('decryptedImageOutput').src = decryptedData;
                document.getElementById('decryptedImageOutput').style.display = 'block';
            } catch (e) {
                alert('Decryption failed! Invalid key or corrupted data.');
            }
        }

        
    </script>
  <script>
        // Initialization vector and secret key storage
        const iv = window.crypto.getRandomValues(new Uint8Array(16));
        let secretKey;

        async function generateKey() {
            secretKey = await crypto.subtle.generateKey(
                {
                    name: "AES-CBC",
                    length: 256,
                },
                true,
                ["encrypt", "decrypt"]
            );
        }

        // Function to encrypt a file
        async function encryptFile(file) {
            const fileArrayBuffer = await file.arrayBuffer();
            const encrypted = await crypto.subtle.encrypt(
                {
                    name: "AES-CBC",
                    iv: iv,
                },
                secretKey,
                fileArrayBuffer
            );

            // Store IV at the start of the encrypted data
            const encryptedWithIV = new Uint8Array(iv.byteLength + encrypted.byteLength);
            encryptedWithIV.set(iv, 0);
            encryptedWithIV.set(new Uint8Array(encrypted), iv.byteLength);

            return encryptedWithIV;
        }

        // Function to decrypt a file
        async function decryptFile(encryptedBuffer) {
            // Extract IV from the first 16 bytes of the buffer
            const ivFromFile = encryptedBuffer.slice(0, 16);
            const encryptedContent = encryptedBuffer.slice(16);

            try {
                const decrypted = await crypto.subtle.decrypt(
                    {
                        name: "AES-CBC",
                        iv: ivFromFile,
                    },
                    secretKey,
                    encryptedContent
                );
                return decrypted;
            } catch (e) {
                console.error("Decryption failed", e);
                alert("Decryption failed! Ensure you used the correct file and key.");
            }
        }

        // Event listener for encryption
        document.getElementById("encryptButton").addEventListener("click", async () => {
            const file = document.getElementById("fileInput").files[0];
            if (file) {
                await generateKey();
                const encrypted = await encryptFile(file);
                const blob = new Blob([encrypted], { type: "application/octet-stream" });
                const url = URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = file.name + ".enc";
                a.click();
                URL.revokeObjectURL(url);
                alert("File encrypted successfully!");
            } else {
                alert("Please select a file to encrypt!");
            }
        });

        // Event listener for decryption
        document.getElementById("decryptButton").addEventListener("click", async () => {
            const file = document.getElementById("fileToDecrypt").files[0];
            if (file) {
                const encryptedBuffer = await file.arrayBuffer();
                const decrypted = await decryptFile(encryptedBuffer);
                if (decrypted) {
                    const blob = new Blob([decrypted], { type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document" });
                    const url = URL.createObjectURL(blob);
                    const downloadLink = document.getElementById("downloadLink");
                    downloadLink.href = url;
                    downloadLink.download = "decrypted_file.docx";
                    downloadLink.style.display = 'block';
                }
            } else {
                alert("Please select a file to decrypt!");
            }
        });
    </script>
  <script>
     async function encryptVideo(file) {
            try {
                if (!file) {
                    alert('Please select a video to encrypt!');
                    return;
                }

                const fileArrayBuffer = await file.arrayBuffer();
                const encrypted = await crypto.subtle.encrypt(
                    { name: 'AES-CBC', iv: iv },
                    secretKey,
                    fileArrayBuffer
                );

                const encryptedWithIV = new Uint8Array(iv.byteLength + encrypted.byteLength);
                encryptedWithIV.set(iv, 0);
                encryptedWithIV.set(new Uint8Array(encrypted), iv.byteLength);

                const blob = new Blob([encryptedWithIV], { type: 'application/octet-stream' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = file.name + '.enc';
                a.click();
                URL.revokeObjectURL(url);
                alert('Video encrypted successfully!');
            } catch (error) {
                console.error('Error during video encryption:', error);
                alert('An error occurred during video encryption.');
            }
        }

        async function decryptVideo(file) {
            try {
                if (!file) {
                    alert('Please select a video to decrypt!');
                    return;
                }

                const encryptedBuffer = await file.arrayBuffer();
                const ivFromFile = encryptedBuffer.slice(0, 16);
                const encryptedContent = encryptedBuffer.slice(16);

                const decrypted = await crypto.subtle.decrypt(
                    { name: 'AES-CBC', iv: ivFromFile },
                    secretKey,
                    encryptedContent
                );

                const blob = new Blob([decrypted], { type: 'video/mp4' });
                const url = URL.createObjectURL(blob);
                const downloadLink = document.getElementById('downloadVideoLink');
                downloadLink.href = url;
                downloadLink.download = 'decrypted_video.mp4';
                downloadLink.style.display = 'block';
                alert('Video decrypted successfully!');
            } catch (e) {
                console.error('Decryption failed', e);
                alert('Decryption failed! Ensure you used the correct video and key.');
            }
        }

        document.getElementById('encryptVideoButton').addEventListener('click', async () => {
            const videoFile = document.getElementById('videoInput').files[0];
            await generateKey();
            await encryptVideo(videoFile);
        });

        document.getElementById('decryptVideoButton').addEventListener('click', async () => {
            const encryptedVideoFile = document.getElementById('videoToDecrypt').files[0];
            await decryptVideo(encryptedVideoFile);
        });
    </script>
    <script>
        const reviewContainer = document.getElementById('reviewContainer');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        let reviewCards = document.querySelectorAll('.review-card');
        let visibleReviews = 5; // Show first 5 reviews initially

        function showReviews() {
            reviewCards.forEach((card, index) => {
                if (index < visibleReviews) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            if (visibleReviews >= reviewCards.length) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.style.display = 'block';
            }
        }

        loadMoreBtn.addEventListener('click', function () {
            visibleReviews += 5; // Load 5 more reviews each time
            showReviews();
        });

        // Initial display of reviews
        showReviews();
    </script>

</body>
</html>
