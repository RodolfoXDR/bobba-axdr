<?php
if(!isset($_POST['widgetId'], $_POST['_mypage_requested_account']) || !is_numeric($_POST['widgetId']) || !is_numeric($_POST['_mypage_requested_account']))
	exit;
require '../../../KERNEL-XDRCMS/Init.php';

$s = (isset($_POST['pageNumber']) && is_numeric($_POST['pageNumber']) && $_POST['pageNumber'] > -1 && $_POST['pageNumber'] < 10000) ? $_POST['pageNumber'] : 0;

$uQ = SQL::query('SELECT badge_id FROM users_badges WHERE user_id = ' . $_POST['_mypage_requested_account'] . ' ORDER BY id DESC LIMIT ' . ($s-1)*16 . ',16');
$uC = SQL::query('SELECT Count(*) FROM users_badges WHERE user_id = ' . $_POST['_mypage_requested_account']);

if(!$uC || !$uQ)
	exit;
	
$uC = $uC->fetch_assoc()['Count(*)'];
$uT = $uQ->num_rows;
?>
    <ul class="clearfix">
<?php while($uR = $uQ->fetch_assoc()): ?>
					<li title="" style="background-image: url(<?php echo Site::$Settings['badgesPath'] . '/' . $uR['badge_id']; ?>.gif)"></li>
<?php endwhile; ?>
    </ul>

        <div id="badge-list-paging">
		<?php echo ($s - 1) * 16; ?> - <?php echo 16*($s) - (16 - $uT); ?> / <?php echo $uC; ?>
        <br/>
<?php if($s != 1): ?>
        <a href="#" id="badge-list-search-first" >Primero</a> |
        <a  href="#" id="badge-list-search-previous" >&lt;&lt;</a> |
<?php else: ?>
    Primero |
    &lt;&lt; |
<?php endif; if($uC > 16*($s)): ?>
	<a href="#" id="badge-list-search-next">&gt;&gt;</a> |
	<a href="#" id="badge-list-search-last">Último</a>
<?php else: ?>
	&gt;&gt; |
	Último
<?php endif; ?>
        <input type="hidden" id="badgeListPageNumber" value="<?php echo $s; ?>"/>
        <input type="hidden" id="badgeListTotalPages" value="<?php echo ceil($uC / $uQ->num_rows); ?>"/>
        </div>