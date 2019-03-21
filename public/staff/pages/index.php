<?php
    require_once('../../../private/initialize.php');
    $page_set = find_all_pages();
    $page_title="pages";
    include(SHARED_PATH . '/staff_header.php');
?>
<div id="content">
    <div class="content listing">
        <h1>Pages</h1>
        <div class="actions">
                                        <!-- ECHOOOOOO!! -->
            <a class="action" href="<?php echo url_for('/staff/pages/new.php'); ?>">Create new page</a>
            <table class="list">
                <tr>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Page Name</th>
                    <th>Position</th>
                    <th>Visible</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                <?php while($page=mysqli_fetch_assoc($page_set)) { ?>
                <tr>
                    <?php $subject = find_subject_by_id($page['subject_id']); ?> 
                    <td><?php echo h($page['id']); ?></td>
                    <td><?php echo h($subject['menu_name']); ?></td>
                    <td><?php echo h($page['menu_name']); ?></td>
                    <td><?php echo h($page['position']); ?></td>
                    <td><?php echo h($page['visible'] == 1 ? 'true':'false'); ?></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id='.h(u($page['id']))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id='.h(u($page['id']))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id='.h(u($page['id']))); ?>">Delete</a></td>
                </tr>
                <?php } ?>
            </table>
            <?php
                var_dump($subject['menu_name']);
                mysqli_free_result($page_set);
            ?>
        </div>
    </div>
</div>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>