<?php include_once THEMES . Settings::getTheme() . '/plugins/generic-header.tpl'; ?>

<div class="center-news-whole-page">
  <div class="center-news-whole">
    <div class="center-news-title">
      <h1><?php echo $tpl->news['title']; ?></h1>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="center-news-subtitle-left">
          &nbsp;
        </td>
        <td class="center-news-subtitle-center">
          <div class="center-news-subtitle-center-date">
            <img src="<?php echo Settings::getAddressSite() . THEMES . Settings::getTheme() . '/images/date.png'; ?>" />
          </div>&nbsp;
          <?php echo date('d-m-Y, H:i', $tpl->news['date']); ?>
          <div class="center-news-subtitle-center-author">
            Автор: <?php echo $tpl->news['author_name']; ?>
          </div>
        </td>
        <td class="center-news-subtitle-right">
          &nbsp;
        </td>
      </tr>
    </table>
    <div class="center-news-body">
      <?php echo $tpl->news['body']; ?>
    </div>
  </div>
  <div class="center-news-hsep">
    &nbsp;
  </div>
  <div class="news-read-more-comments-whole">
    <div class="news-read-more-comments-title">
      Комментарии
    </div>
    <span class="news-read-more-msg-error">
      <?php echo Messages::getInstance()->getMessage('news-addcomment-error', true); ?>
    </span>
    <span class="news-read-more-msg-message">
      <?php echo Messages::getInstance()->getMessage('news-addcomment-message', false); ?>
    </span>
    <span class="news-read-more-msg-error">
      <?php echo Messages::getInstance()->getMessage('news-deletecomment-error', true); ?>
    </span>
    <span class="news-read-more-msg-message">
      <?php echo Messages::getInstance()->getMessage('news-deletecomment-message', false); ?>
    </span>
    <?php foreach($tpl->news['comments'] as $comment) { ?>
    <div class="news-read-more-comments-comment-whole">
      <div>
        <div class="news-read-more-comments-comment-author">
          <a name="<?php echo $comment['order']; ?>"></a>
          #<a href="<?php echo Settings::getAddressSite() . 'news/more/' . $tpl->news['id'] . '#' . $comment['order']; ?>"><?php echo $comment['order']; ?></a>  От: <span id="addcomment-author-<?php echo $comment['order']; ?>"><?php echo $comment['author_name']; ?></span>
          <?php echo $_SESSION['role'] === 'admin' ? '| ' . $comment['author_ip'] : ''; ?>
        </div>
        <div class="news-read-more-comments-comment-date">
          <?php echo $_SESSION['role'] === 'admin' ? '<a class="deletecomment-link" title="Удалить комментрарий" href="' . Settings::getAddressSite() . 'news/deletecomment/' . $tpl->news['id'] . '/' . $comment['id'] . '"><img width="17" height="17" src="' . Settings::getAddressSite() . THEMES . Settings::getTheme() . '/images/delete.png"></a>' : ''; ?> 
          <?php echo date('d-m-Y, H:i', $comment['date']); ?>
        </div>
      </div>
      <div id="addcomment-text-<?php echo $comment['order']; ?>">
        <?php echo $comment['text']; ?>
      </div>
      <div align="right">
        <a href="#reply-to-<?php echo $comment['order']; ?>" class="reply-to">Ответить</a>
      </div>
    </div>
    <?php } ?>
    <div class="news-read-more-comments-comment-form">
      <form id="addcomment-form" action="<?php echo Settings::getAddressSite() . 'news/addcomment/' . $tpl->news['id']; ?>" method="POST">
        <input id="addcomment-form-author" type="input" size="40" name="author_name" value="Введите ваше имя" /><br />
        <textarea id="addcomment-form-text" cols="80" rows="8" name="text" /></textarea><br />
        <input id="addcomment-form-submit" type="submit" name="submit" value="Комментировать" />
      </form>
    </div>
  </div>
</div>

<?php include_once THEMES . Settings::getTheme() . '/plugins/generic-footer.tpl'; ?>                  
