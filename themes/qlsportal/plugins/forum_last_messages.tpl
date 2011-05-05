<div>
  <h3>Сообщения старого форума</h3>
</div>
<div style="margin: 15px 0 0 -15px;">
  <?php foreach($tpl->topics as $topic) { ?>
  <div style="font-size: 1.1em;">
    <span style="color: <?php echo $topic['today'] ? 'green' : 'orange'; ?>;"><b>&raquo;</b></span>
    <a style="text-decoration: underline;" href="http://forum.<?php echo Settings::getDomainSite(); ?>/index.php?showtopic=<?php echo $topic['id']; ?>&view=getnewpost" target="_blank"><b><?php echo $topic['title']; ?></b></a>
    <div style="color: #939393; font-size: 0.9em;">
      Автор: <?php echo $topic['name']; ?>
    </div>
  </div>
  <?php } ?>
</div>
