<?php
$mainframe = JFactory::getApplication();
$mailbody = '<!DOCTYPE html><html lang="ru">
<head><meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Банковская квитанция формы ПД-4</title><br /><br />
</head>
<body>

<table width="780" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
  <tr>
    <td width="215"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="left_table"><div align="center"><strong>Извещение </strong></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="left_table"><div align="center"><strong>Кассир</strong></div></td>
      </tr>
    </table></td>
    <td><table  align="center" width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="33"></td>
        </tr>
      <tr>
        <td colspan="22">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="22">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  			<tr>
    		<td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $params['pay_Cname'].'</div></td>
    		<td width="120" style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="right">КПП: '. $params['pay_KppN'].'</div></td>
  			</tr>
		</table></td>
        </tr>
      <tr>
        <td colspan="22" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="22" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(наименование получателя платежа)</td>
        </tr>
      <tr>
        <td>
           	<table width="170" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          	<tr>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][0].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][1].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][2].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][3].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][4].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][5].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][6].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][7].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][8].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][9].'</div></td>
          </tr>
        </table>          </td>
        <td colspan="21"><div align="right">
        <table width="340" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" height="4mm" style="border-collapse:collapse">
            <tr>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][0].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][1].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][2].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][3].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][4].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][5].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][6].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][7].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][8].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][9].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][10].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][11].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][12].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][13].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][14].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][15].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][16].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][17].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][18].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][19].'</div></td>
            </tr>
          </table></div></td>
      </tr>
      <tr>
        <td style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(ИНН получателя платежа)</td>
        <td></td>

        <td></td>
        <td colspan="19" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(номер счета получателя платежа)</td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" style="font-size:8.5pt;">в</td>
            <td width="355" style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt; text-align:center">'. $params['pay_Bname'].'</td>
            <td style="font-size:8.5pt;">БИК</td>
            <td><div align="right"><table width="153" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style=" border-collapse:collapse" >
          <tr height="4mm">
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][0].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][1].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][2].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][3].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][4].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][5].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][6].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][7].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][8].'</div></td>
          </tr>
        </table></div></td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0" height="1">
          <tr>
            <td></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td width="15"></td>
            <td width="345" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Наименование банка получателя платежа)</td>
            <td width="180"></td>
            <td width="10"></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;">Номер кор./сч. банка получателя платежа</td>
            <td><div align="right"><table width="340" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" height="4mm" style="border-collapse:collapse">
            <tr>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][0].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][1].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][2].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][3].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][4].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][5].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][6].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][7].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][8].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][9].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][10].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][11].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][12].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][13].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][14].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][15].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][16].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][17].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][18].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][19].'</div></td>
            </tr>
          </table></div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">Оплата товаров по заказу №: '. $order->order_number.'</div></td>
            <td width="25"></td>
            <td width="230"></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="25"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
            <td width="345" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Наименование платежа)</td>
            <td width="25"></td>
            <td width="230" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Номер лицевого счета (код) плательщика)</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110">Ф.И.О. плательщика</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $order->l_name.'&nbsp;'. $order->f_name.'</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110">Адрес плательщика</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $order->zip.',&nbsp;'. $order->city.',&nbsp;'. $order->street.'</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="110"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="80">Сумма платежа</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt; text-align:center;" width="70">'.$order->order_total.'</td>
            <td style="font-size:8.5pt;" width="30">'. $order->currency_code .'</td>
            <td width="80"></td>
            <td style="font-size:8.5pt;" width="120">Сумма платы за услуги</td>
            <td width="70"></td>
            <td style="font-size:8.5pt;" width="30">'. $order->currency_code .'</td>
            <td width="70"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center" style="width:90%">&nbsp;</div></td>
            <td width="30"></td>
            <td width="80" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="left" >&nbsp;</div></td>
            <td width="120"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="30"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="40">Итого </td>
            <td width="70">&nbsp;</td>
            <td style="font-size:8.5pt;" width="30">руб.</td>
            <td width="70">&nbsp;</td>
            <td style="font-size:8.5pt; text-align:right">&laquo;______&raquo;_______________________20____г.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="40"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="30"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="339"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22" style="font-size:8.5pt;">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за услуги банка, ознакомлен и согласен</td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="250"></td>
            <td width="299" style="font-size:8.5pt; font-weight:bold;">Подпись плательщика_____________________________</td>
          </tr>
        </table></td>
        </tr>
        <tr><td colspan="22" style="font-size:4px">&nbsp;</td></tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="left_table"><div align="center"><strong>Квитанция</strong></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="left_table"><div align="center"><strong>Кассир</strong></div></td>
      </tr>
    </table></td>
    <td><table  align="center" width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="33"></td>
        </tr>
      <tr>
        <td colspan="22">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="22">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  			<tr>
    		<td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $params['pay_Cname'].'</div></td>
    		<td width="120" style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="right">КПП: '. $params['pay_KppN'].'</div></td>
  			</tr>
		</table></td>
        </tr>
      <tr>
        <td colspan="22" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="22" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(наименование получателя платежа)</td>
        </tr>
      <tr>
        <td>
           	<table width="170" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          	<tr>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][0].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][1].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][2].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][3].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][4].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][5].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][6].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][7].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][8].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_inn'][9].'</div></td>
          </tr>
        </table>          </td>
        <td colspan="21"><div align="right">
        <table width="340" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" height="4mm" style="border-collapse:collapse">
            <tr>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][0].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][1].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][2].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][3].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][4].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][5].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][6].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][7].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][8].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][9].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][10].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][11].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][12].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][13].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][14].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][15].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][16].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][17].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][18].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_BAccN'][19].'</div></td>
            </tr>
          </table></div></td>
      </tr>
      <tr>
        <td style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(ИНН получателя платежа)</td>
        <td></td>
        <td></td>
        <td colspan="19" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">(номер счета получателя платежа)</td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" style="font-size:8.5pt;">в</td>
            <td width="355" style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt; text-align:center">'. $params['pay_Bname'].'</td>
            <td style="font-size:8.5pt;">БИК</td>
            <td><div align="right"><table width="153" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style=" border-collapse:collapse" >
          <tr height="4mm">
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][0].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][1].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][2].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][3].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][4].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][5].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][6].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][7].'</div></td>
            <td style="font-weight: bold;	font-size: 9pt; font-family: Arial, sans-serif;	width:10%"><div align="center" valign="center">'. $params['pay_BikN'][8].'</div></td>
          </tr>
        </table></div></td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0" height="1">
          <tr>
            <td></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td width="15"></td>
            <td width="345" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Наименование банка получателя платежа)</td>
            <td width="180"></td>
            <td width="10"></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;">Номер кор./сч. банка получателя платежа</td>
            <td><div align="right"><table width="340" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" height="4mm" style="border-collapse:collapse">
            <tr>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][0].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][1].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][2].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][3].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][4].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][5].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][6].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][7].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][8].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][9].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][10].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][11].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][12].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][13].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][14].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][15].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][16].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][17].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][18].'</div></td>
              <td style="font-weight: bold; font-size: 9pt; font-family: Arial, sans-serif; width:5%" ><div align="center" valign="center">'. $params['pay_Kor'][19].'</div></td>
            </tr>
          </table></div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">Оплата товаров по заказу №: '. $order->order_number.'</div></td>
            <td width="25"></td>
            <td width="230"></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="25"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
            <td width="345" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Наименование платежа)</td>
            <td width="25"></td>
            <td width="230" style="font-size: 6pt; font-family: Times New Roman, serif; line-height: 1; text-align:center; vertical-align:top;">
              (Номер лицевого счета (код) плательщика)</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110">Ф.И.О. плательщика</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $order->l_name.'&nbsp;'. $order->f_name.'</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="110">Адрес плательщика</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt;"><div align="center">'. $order->zip.',&nbsp;'. $order->city.',&nbsp;'. $order->street.'</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="110"></td>
            <td style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="80">Сумма платежа</td>
            <td style="font-family: Arial, Helvetica, sans-serif; font-weight:bold; font-size:9pt; text-align:center;" width="70">'. $order->order_total.'</td>
            <td style="font-size:8.5pt;" width="30">'. $order->currency_code .'</td>
            <td width="80"></td>
            <td style="font-size:8.5pt;" width="120">Сумма платы за услуги</td>
            <td width="70"></td>
            <td style="font-size:8.5pt;" width="30">'. $order->currency_code .'</td>
            <td width="70"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center" style="width:90%">&nbsp;</div></td>
            <td width="30"></td>
            <td width="80" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="left" >&nbsp;</div></td>
            <td width="120"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="30"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="font-size:8.5pt;" width="40">Итого </td>
            <td width="70">&nbsp;</td>
            <td style="font-size:8.5pt;" width="30">руб.</td>
            <td width="70">&nbsp;</td>
            <td style="font-size:8.5pt; text-align:right">&laquo;______&raquo;_______________________20____г.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="40"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="30"></td>
            <td width="70" style="background:#FFFFFF; border-top:1px solid #000000; font-size:1px; height:1px; overflow:hidden;"><div align="center">&nbsp;</div></td>
            <td width="339"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="22" style="font-size:8.5pt;">С условиями приема указанной в платежном документе суммы, в т.ч. с суммой взимаемой платы за услуги банка, ознакомлен и согласен</td>
        </tr>
      <tr>
        <td colspan="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="250"></td>
            <td width="299" style="font-size:8.5pt; font-weight:bold;">Подпись плательщика_____________________________</td>
          </tr>
        </table></td>
        </tr>
        <tr><td colspan="22" style="font-size:4px">&nbsp;</td></tr>
    </table></td>
  </tr>
</table>
</body>
</html>
';


        $mailfrom = $mainframe->getCfg( 'mailfrom' );
        $fromname = $mainframe->getCfg( 'fromname' );
	
        //send mail client 		
		$mailer = JFactory::getMailer();
        $mailer->setSender(array($mailfrom, $fromname));
		$mailer->addRecipient($order->email);        
		$mailer->setSubject( sprintf($params['pay_Subj']." ".$order->order_number));
		$mailer->setBody($mailbody);
        $mailer->isHTML(true);
        $send =& $mailer->Send();

        //send mail admin        
        if ($params['copy_admin']){
            $mailer = JFactory::getMailer();
            $mailer->setSender(array($mailfrom, $fromname));
         // $mailer->addRecipient($jshopConfig->contact_email);
			$mailer->addRecipient($params['admin_mail']); 
            $mailer->setSubject( sprintf($params['pay_Subj']." ".$order->order_number));
            $mailer->setBody($mailbody);
            $mailer->isHTML(true);
            $send =& $mailer->Send();
        }		
			
?>		