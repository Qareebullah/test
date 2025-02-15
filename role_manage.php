<?php
include('../includes/db_connection.php');
// Assuming you're connected to the database
$roles = ['Admin', 'CRM', 'HT', 'Teacher'];
$pagesQuery = "SELECT * FROM pages";
$pagesResult = $conn->query($pagesQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    foreach ($roles as $role) {
        if (isset($_POST[$role])) {
            $selectedPages = $_POST[$role]; // Array of selected pages for this role
            // Add or update page URLs for the selected role
            foreach ($selectedPages as $pagename) {
                $page_url = '/School/' . $role . '/' . $pagename . '.php';
                // Insert or update the page URL for the given role and page name
                $stmt = $conn->prepare("REPLACE INTO pages (pagename, role, page_url) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $pagename, $role, $page_url);
                $stmt->execute();
            }
        }
    }
}
?>

<form method="POST">
    <h2>Assign Pages to Roles</h2>
    <?php foreach ($roles as $role): ?>
        <fieldset>
            <legend><?= $role ?> Pages</legend>
            <?php while ($row = $pagesResult->fetch_assoc()): ?>
                <label>
                    <input type="checkbox" name="<?= $role ?>[]" value="<?= $row['pagename'] ?>" 
                        <?php
                        // Check if this page is assigned to the current role
                        $checkQuery = $conn->prepare("SELECT 1 FROM pages WHERE pagename = ? AND role = ?");
                        $checkQuery->bind_param('ss', $row['pagename'], $role);
                        $checkQuery->execute();
                        if ($checkQuery->get_result()->num_rows > 0) {
                            echo 'checked';
                        }
                        ?>>
                    <?= $row['pagename'] ?>
                </label><br>
            <?php endwhile; ?>
        </fieldset>
    <?php endforeach; ?>
    <button type="submit">Save Changes</button>
</form>
