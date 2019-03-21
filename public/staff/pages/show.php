<?php
    require_once('../../../private/initialize.php');
    $id = $_GET['id'] ?? '1';
    $page_title="Show Page";
    include(SHARED_PATH . '/staff_header.php');
    $page = find_table_by_id('pages',$id);
?>
<div id="content">
    <a class="back-link"href="<?php echo url_for('/staff/pages/index.php');?>">&laquo; Back to List</a>

    <div class="page show">

    <h1>Page: <?php echo h($page['menu_name']); ?></h1>

        <div class="attributes">
            <dl>
            <dt>Subject</dt>
                <?php $subject= find_table_by_id('subjects',$page['subject_id']); ?>
                <dd><?php echo h($subject['menu_name']); ?></dd>
            </dl>
            <dl>
            <dt>Menu Name</dt>
                <dd><?php echo h($page['menu_name']); ?></dd>
            </dl>
            <dl>
            <dt>Position</dt>
                <dd><?php echo h($page['position']); ?></dd>
            </dl>
            <dl>
            <dt>Visible</dt>
                <dd><?php echo $page['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
            <dl>
            <dt>Content</dt>
                <dd><?php echo $page['content']?></dd>
            </dl>

        </div>

    </div>

</div>
<?php include(SHARED_PATH . '/staff_footer.php'); ?>