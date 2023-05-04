<table class="top-dash tbl_gradient">
    <tr>
        <th><img src="images/graph-icon.png" width="20" /> Statistik Kehadiran</th>
        <th><img src="images/pie-icon.png" width="15" />&nbsp; Statistik Penilaian (Peserta Bengkel & Pembentang Kertas Kerja)</th>
    </tr>
    <tr>
        <td><?php echo $this->renderPartial('dashboard/_kehadiran', array('data'=>$kehadiran));?></td>
        <td><?php echo $this->renderPartial('dashboard/_survey', array('data'=>$survey));?></td>
    </tr>
</table>
<table class="top-dash tbl_gradient">
    <tr>
        <th style="font-size: 12pt"><img src="images/bar-icon.png" width="20" /> Statistik Bilangan Penilaian (Peserta Bengkel & Pembentang Kertas Kerja)</th>
    </tr>
    <tr>
        <td><?php echo $this->renderPartial('dashboard/_purata', array('data'=>$data)); ?></td>
    </tr>
</table>
<table class="top-dash tbl_gradient">
    <tr>
        <th style="font-size: 12pt"><img src="images/bar-icon.png" width="20" /> Statistik Bilangan Penilaian (Bahagian F)</th>
    </tr>
    <tr>
        <td><?php echo $this->renderPartial('dashboard/_summary_bhgf', array('data'=>$partf)); ?></td>
    </tr>
</table>
<table class="top-dash tbl_gradient">
    <tr>
        <th style="font-size: 12pt"><img src="images/bar-icon.png" width="20" /> Statistik Purata Penilaian</th>
    </tr>
    <tr>
        <td><?php echo $this->renderPartial('dashboard/_purata_bhgf', array('data'=>$avgpartf, 'category'=>$category)); ?></td>
    </tr>
</table>
<table class="top-dash tbl_gradient">
    <tr>
        <th style="font-size: 12pt"><img src="images/bar-icon.png" width="20" /> Legend</th>
    </tr>
    <tr>
        <td><?php echo $this->renderPartial('dashboard/_legend', array('data'=>$category)); ?></td>
    </tr>
</table>