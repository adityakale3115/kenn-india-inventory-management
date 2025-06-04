<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    .sidebar {
        width: 250px;
        height: 100vh;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 10px;
        box-sizing: border-box;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .sidebar a {
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 10px;
        white-space: nowrap;
    }
    .sidebar a i {
        margin-right: 10px;
        font-size: 16px;
    }
</style>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Kenn India</h2>
    <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="machine.php"><i class="fa-solid fa-screwdriver-wrench"></i> Machine Master</a>
    <a href="material.php"><i class="fa-solid fa-cube"></i> Material Master</a>
    <a href="parts.php"><i class="fa-solid fa-gear"></i> Parts Master</a>
    <a href="vendor.php"><i class="fas fa-id-badge"></i> Vendor Master</a>
    <a href="customer.php"><i class="fas fa-user"></i> Customer Master</a>
    <a href="project.php" ><i class="fa-regular fa-file"></i> Project Master</a>
    <a href="items.php"><i class="fa-solid fa-puzzle-piece"></i> Item Master</a>
    <a href="po.php"><i class="fa-solid fa-list"></i> PO Master</a>
</div>
