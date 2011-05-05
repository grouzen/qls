<div>
  <h3><span style="color: green;">Сообщения форума</span></h3>
</div>
<div style="margin: 15px 0 0 -15px;">
  <?php foreach($tpl->phpbb_topics as $topic) { ?>
  <div style="font-size: 1.1em;">
    <span style="color: <?php echo $topic['today'] ? 'green' : 'orange'; ?>;"><b>&raquo;</b></span>
    <a style="text-decoration: underline;" href="http://forum.<?php echo Settings::getDomainSite(); ?>/viewtopic.php?f=<?php echo $topic['fid']; ?>&t=<?php echo $topic['tid']; ?>&p=<?php echo $topic['lpid']; ?>#p<?php echo $topic['lpid']; ?>" target="_blank"><b><?php echo $topic['title']; ?></b></a>
    <div style="color: #939393; font-size: 0.9em;">
      Автор: <?php echo $topic['username']; ?>
    </div>
  </div>
  <?php } ?>
</div>
