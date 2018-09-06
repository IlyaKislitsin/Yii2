<?php
/* @var $this yii\web\View */

?>
        <script language="JavaScript">
            var conn = new WebSocket('ws://localhost:8081');
            conn.onopen = function(e) {
                console.log('Connection established!');
            };

            conn.onmessage = function(e) {
                console.log(e.data);
            };
        </script>

<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 30.08.2018
 * Time: 14:40
 */
