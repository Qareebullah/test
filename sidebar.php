<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Academic Sidebar</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    rel="stylesheet" />

  <style>
    body {
      margin: 0;
      min-height: fit-content !important;
    }

    #sidebar {
      background-color: black;
      border-right: 2px solid white;
      /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
      padding-top: 20px;
      position: fixed;
      top: 0;
      bottom: 0;
      width: 250px;
      transition: width 0.3s ease;
    }

    #sidebar.collapsed {
      width: 70px;
    }

    #content {
      transition: margin-left 0.3s ease !important;
      padding: 10px !important;
      margin-top: 100px;
    }

    #sidebar.collapsed+#content {
      margin-left: 70px !important;
    }

    #sidebar ul li {
      padding: 15px 25px;
      border-left: 2px solid transparent;
      transition: background-color 0.3s ease;
    }

    #sidebar ul li a {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #sidebar ul {
      list-style-type: none;
      padding: 0;
    }

    #sidebar ul li:hover {
      background-color: white;
      /* border-left: 2px solid black; */
    }

    #sidebar ul li:hover a {
      color: black;
    }

    #sidebar ul li a {
      text-decoration: none;
      color: white;
      font-weight: 500;
    }

    #sidebar.collapsed ul li a span {
      display: none;
    }

    #sidebar ul li a span {
      margin-left: 20px;
    }

    #sidebar ul li a i {
      width: 10%;
    }

    #toggle-button {
      background: none;
      border: none;
      position: absolute;
      right: 25px;
      top: 25px;
      cursor: pointer;
      transition: right 0.3s;
      color: white;
    }

    .toggle-div {
      padding: 22px;
      border-bottom: 2px solid white;
    }

    /* Custom Scrollbar Styles for the dashboard */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
      border: 1px solid white;
    }

    ::-webkit-scrollbar-thumb {
      background: white;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: white;
    }
  </style>
</head>

<body>
  <div id="sidebar">
    <ul>
      <div class="toggle-div">
        <button id="toggle-button" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>
      </div>
      <li class="mt-3">
        <a href="index.php"><i class="fas fa-tachometer-alt"></i><span> Dashboard</span></a>
      </li>
      <li>
        <a href="students.php"><i class="fas fa-user-graduate"></i><span> Students</span></a>
      </li>
      <li>
        <a href="attendance.php"><i class="fas fa-calendar-check"></i><span> Attendance</span></a>
      </li>
      <li>
        <a href="classes.php"><i class="fas fa-chalkboard"></i><span> Classes</span></a>
      </li>
      <li>
        <a href="subjects.php"><i class="fas fa-book"></i><span> Subjects</span></a>
      </li>
      <li>
        <a href="teachers.php"><i class="fas fa-user-tie"></i><span> Teachers</span></a>
      </li>
      <li>
        <a href="search.php"><i class="fas fa-search"></i><span> Search</span></a>
      </li>
      <li>
        <a href="letters.php"><i class="fas fa-paper-plane"></i><span> Letters</span></a>
      </li>
      <li>
        <a href="referrals.php"><i class="fas fa-users-cog"></i><span> Referrals</span></a>
      </li>

    </ul>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    window.addEventListener("load", adjustSidebar);
    window.addEventListener("resize", adjustSidebar);

    function adjustSidebar() {
      const content = document.getElementById("content");
      if (window.innerWidth >= 100) {
        document.getElementById("sidebar").classList.add("collapsed");
        if (sidebar.classList.contains("collapsed")) {
          content.style.marginLeft = "70px";
        }
      } else {
        document.getElementById("sidebar").classList.remove("collapsed");
      }
    }

    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      const content = document.getElementById("content");

      sidebar.classList.toggle("collapsed");

      if (sidebar.classList.contains("collapsed")) {
        content.style.marginLeft = "70px";
      } else {
        content.style.marginLeft = "250px";
      }
    }
  </script>
</body>

</html>