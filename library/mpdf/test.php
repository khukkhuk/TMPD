<!--<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://www.tmpd.com/user/confirm_recieve.php?id=16&choe=UTF-8" title="Link to my Website" />-->
<style type="text/css" media="print">
@page 
    {
        size: auto;   /* กำหนดขนาดของหน้าเอกสารเป็นออโต้ครับ */
        margin: 0mm;  /* กำหนดขอบกระดาษเป็น 0 มม. */
    }

    body 
    {
        margin: 0px;  /* เป็นการกำหนดขอบกระดาษของเนื้อหาที่จะพิมพ์ก่อนที่จะส่งไปให้เครื่องพิมพ์ครับ */
        
  font-family: "THSarabun";
    }

</style>
<form method="POST" action="index.php">
<table>
	<tr><td>รหัสเอกสาร</td><td><input type="text" name="doc_id"></td></tr>
	<tr><td>วันที่</td><td><input type="date" name="add_date"></td></tr>
	<tr><td>หัวข้อ</td><td><input type="text" name="topic"></td></tr>
	<tr><td>ส่งถึง</td><td><input type="text" name="send_to"></td></tr>
	<tr><td>ย่อหน้าที่ 1</td><td>  <textarea name="value1"></textarea></td></tr>
	<tr><td>ย่อหน้าที่ 2</td><td>  <textarea name="value2"></textarea></td></tr>
	<tr><td>ย่อหน้าที่ 3</td><td>  <textarea name="value3"></textarea></td></tr>
    <tr><td>ชื่อผู้รับรอง</td><td><input type="text" name="name"></td></tr>
    <tr><td>ตำแหน่ง</td><td><input type="text" name="position"></td></tr>
	<tr><td colspan="2"><input type="submit" name=""><input type="reset" name=""></td></tr>
</table>
</form>	