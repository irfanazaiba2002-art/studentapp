<?php
// index.php — College homepage
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>St Joseph - Home</title>

  <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

  :root {
    --accent:#2c67f2;
    --muted:#d1d5db;
    --card:#ffffffee;
  }

  * { box-sizing:border-box; }
  body,html { margin:0; padding:0; font-family:Inter; scroll-behavior:smooth; }

  /* HERO SECTION */
  .hero {
    background-image: url('images/college.jpg');
    background-size: cover;
    background-position: center;
    height:100vh;
    position:relative;
    color:white;
  }

  .hero::before {
    content:"";
    position:absolute;
    top:0;left:0;width:100%;height:100%;
    background: rgba(0,0,0,0.45);
    z-index:0;
  }

  .nav {
    position:relative;
    z-index:5;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 36px;
    background: rgba(0,0,0,0.30);
    backdrop-filter: blur(4px);
  }

  .nav .links a {
    color:white;
    text-decoration:none;
    font-weight:600;
    padding:8px 12px;
    border-radius:8px;
  }
  .nav .links a:hover { background:rgba(255,255,255,0.12); }
  .cta { background:var(--accent); }

  .hero-content {
    position:relative;
    z-index:5;
    display:flex;
    justify-content:center;
    align-items:center;
    height:calc(100vh - 80px);
    padding:40px;
  }

  .card {
    max-width:1100px;
    width:100%;
    background: rgba(255,255,255,0.08);
    border-radius:14px;
    padding:34px;
    display:grid;
    grid-template-columns: 1fr 420px;
    gap:28px;
    align-items:center;
    backdrop-filter: blur(6px);
  }

  .left h2 {
    margin:0;
    font-size:34px;
    text-shadow:0 3px 8px rgba(0,0,0,0.6);
  }
  .left p { color:#f3f4f6; margin-top:12px; }

  .features { display:flex; gap:12px; margin-top:18px; }
  .feature { background:rgba(255,255,255,0.14); padding:12px; border-radius:10px; }

  .right {
    background:var(--card);
    color:#0b1220;
    padding:18px;
    border-radius:12px;
    box-shadow:0 8px 30px rgba(2,6,23,0.22);
  }

  /* PAGE SECTIONS */
  section {
    padding:60px 40px;
  }

  #about { background:#f5f5f5; }
  #courses { background:white; }
  #contact { background:#eef3ff; }

  section h2 {
    font-size:28px;
    margin-bottom:14px;
  }

  /* FOOTER */
  .footer {
    background:#111827;
    color:white;
    text-align:center;
    padding:18px;
  }

  @media(max-width:980px){
    .card { grid-template-columns:1fr; }
  }

  </style>
</head>

<body>

  <!-- HERO SECTION (Home) -->
  <header class="hero" id="home">
    <nav class="nav">
      <div class="brand">
        <img src="images/St-Josephs.jpg" alt="logo" style="height:40px">
        <h1 style="margin-left:10px;font-size:20px">St Joseph University</h1>
      </div>

      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#courses">Courses</a>
        <a href="#contact">Contact</a>
        <a href="login.php" class="cta">Login</a>
      </div>
    </nav>

    <div class="hero-content">
      <div class="card">
        <div class="left">
          <h2>St Joseph — Where learning meets opportunity</h2>
          <p>We prepare students for a bright future through hands-on learning,
             experienced faculty and industry-aligned programs.</p>

          <div class="features">
            <div class="feature"><strong>Experienced Faculty</strong></div>
            <div class="feature"><strong>Industry Projects</strong></div>
            <div class="feature"><strong>Strong Placement</strong></div>
          </div>

          <p style="margin-top:20px">
            <a href="register.php" style="background:#fff;color:#000;padding:10px 14px;border-radius:8px;text-decoration:none;font-weight:700;">Apply Now</a>
            &nbsp;&nbsp;
            <a href="add-student.php" style="color:#fff;border:1px solid rgba(255,255,255,0.2);padding:10px 14px;border-radius:8px;text-decoration:none;">Add Student</a>
          </p>
        </div>

        <aside class="right">
          <h3>Contact & Quick Links</h3>
          <p>Phone: +91 98765 43210</p>
          <p>Email: admissions@stjoseph.edu</p>

          <label>Looking for programs</label>
          <select onchange="if(this.value) location.href=this.value" style="width:100%;padding:10px;border-radius:8px;margin-top:8px;">
            <option value="">Select Course</option>
            <option value="add-course.php">Add Course (Admin)</option>
            <option value="add-subject.php">Add Subjects</option>
            <option value="add-student.php">Add Student</option>
          </select>
        </aside>
      </div>
    </div>
  </header>

  <!-- ABOUT SECTION -->
  <section id="about">
    <h2>About St Joseph University</h2>
    <p>
      St Joseph University is committed to academic excellence and holistic development.
      Our institution offers world-class faculty, modern labs, industry collaborations,
      and a student-first environment.
    </p>
    <p>
      We focus on real-world learning, research, innovation, and strong moral values.
    </p>
  </section>

  <!-- COURSES SECTION -->
  <section id="courses">
    <h2>Our Courses</h2>
    <ul>
      <li>Bachelor of Computer Science</li>
      <li>Bachelor of Business Administration</li>
      <li>Master of Data Science</li>
      <li>Master of Computer Applications</li>
      <li>Electronics & Communication Engineering</li>
      <li>Artificial Intelligence & Machine Learning</li>
    </ul>
  </section>

  <!-- CONTACT SECTION -->
  <section id="contact">
    <h2>Contact Us</h2>
    <p>Phone: +91 98765 43210</p>
    <p>Email: admissions@stjoseph.edu</p>
    <p>Address: St Joseph University, Bangalore, India</p>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    © <?php echo date('Y'); ?> St Joseph — All rights reserved
  </footer>

</body>
</html>
