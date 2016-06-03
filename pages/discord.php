<table class="layout-table">
  <tr>
    <td style="vertical-align: top;">
      <table class="outline margin homepage">
        <tr class="cell1">
          <td style="padding:5px;">
            <h2 style="text-align: center">Discord Chat</h2>
            <pre id="log">

            </pre>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php
shell_exec('php ../discord.php &');
?>

<script>
var socket = new WebSocket("ws://localhost:3757/");

socket.onmessage = function (event) {
  console.log(event.data);
}
</script>
