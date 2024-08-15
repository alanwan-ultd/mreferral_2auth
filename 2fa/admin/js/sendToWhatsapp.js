function sendToWhatsapp(caseNo = '', referrerContactNo = '') {
	if(!caseNo || !referrerContactNo) {
		return;
	}

	// ajax get cash rebate detail by case no
	$.ajax({
		type: "POST",
		url: 'ajax/cashRebate.php?action=getWhatappDetail',
		dataType: 'json',
		data: {case_no: caseNo},
		success: data => {
			let rst = JSON.parse(data);

			// no result
			if(rst['result'] === 'f') {
				return;
			}

			let text = generateWhatsappTemplate(rst);
			window.open(`https://wa.me/852${referrerContactNo}?text=${text}`, '_blank');
		},
		error: () => {
			console.log('error'+data);
		},
		dataType: 'html'  //xml, json, script, or html
	});
}

function generateWhatsappTemplate(data) {
	const referrer_name = data['referrer_name'];
	const case_no = data['case_no'];
	const referee_name = data['referee_name'];
	const coupon_amount = data['label_coupon_amount'];
	const template = `
		親愛的客戶 ${referrer_name}:%0a
		Case No.%23${case_no} %0a%0a
		多謝  閣下介紹朋友 ${referee_name} 通過本公司( 經絡按揭轉介) 辦理按揭，並已成功在銀行提取貸款，閣下現可獲本公司合共贈送 $${coupon_amount} 百佳超級市場禮券，以表謝意！%0a%0a
		
		閣下可選擇以下形式,到經絡辦事處領取超級市場禮券:%0a
		- 親身 (請預早1-2個工作天預約)  或 %0a
		- 代領 (需另填授權書) %0a
		- 掛號(請在此提供收掛號信的英文地址) %0a%0a
		
		如有疑問請致電鄒小姐 MISS CHAU (3196 6908) 或回覆此信息安排領取. %0a%0a
		
		辦工時間: 星期一至五 – 早上九時至下午六時%0a
						* (星期六、日及公眾假期休息)*%0a%0a
		
		地址: 香港灣仔告士打道160號海外信託銀行大廈17樓%0a
		https://goo.gl/maps/XmMpwTHZwZiwYFjr7%0a%0a
		
		如閣下知道約何時領取? 請告知,以便我們通知同事安排. 謝謝！
	`;

	return template;
}