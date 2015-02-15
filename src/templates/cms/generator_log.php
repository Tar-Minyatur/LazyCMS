<?php $this->layout('cms::template', array('pageTitle' => 'File Generator Result')) ?>

<section id="generatorLog" class="log">
    <h2>File Generator Result</h2>
    <ul>
        <?php foreach ($generatorLog as $logEntry): ?>
            <li><?php echo $this->e($logEntry) ?></li>
        <?php endforeach ?>
    </ul>
</section>