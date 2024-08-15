const json = process.argv.slice(2)[0];
const fetch = require("cross-fetch");
const {PDFDocument, PDFFont} = require('pdf-lib');
const fontkit = require('@pdf-lib/fontkit');
const fs = require('fs');

let jsonData = require(json);
const baseURL = jsonData.baseURL;
const pdfTemplate = jsonData.template;
const output = jsonData.output;
const data = jsonData.data;
const font = baseURL + 'font/PMingLiU.ttf';

async function fillForm() {
	// Fetch the PDF with form fields
	const formUrl = pdfTemplate;
	const fontUrl = font;
	var formPdfBytes;
	var fontBytes;

	if(fontUrl.indexOf("ultd.mreferral.com") > 0) {
		formPdfBytes = await fetch(formUrl, {
			headers: {
				'Authorization': 'Basic ' + Buffer.from(`admin:Ult@123`, 'binary').toString('base64')
			}
		}).then(res => res.arrayBuffer());
	
		fontBytes = await  fetch(fontUrl, {
			headers: {
				'Authorization': 'Basic ' + Buffer.from(`admin:Ult@123`, 'binary').toString('base64')
			}
		}).then((res) => res.arrayBuffer());
	} else {
		formPdfBytes = await fetch(formUrl).then(res => res.arrayBuffer());
		fontBytes = await fetch(fontUrl).then((res) => res.arrayBuffer());
	}

	// Load a PDF with form fields
	const pdfDoc = await PDFDocument.load(formPdfBytes);

	// Embed the Ubuntu font
	pdfDoc.registerFontkit(fontkit);
	const ubuntuFont = await pdfDoc.embedFont(fontBytes, {subset:true});

	// Get the form containing all the fields
	const form = pdfDoc.getForm()

	// Fill the form's fields
	const textdata = data.text;
	const checkboxdata = data.checkbox;
	const imgdata = data.img;

	if(textdata) {
		for (const [key, value] of Object.entries(textdata)) {
			// console.log(`${key}: ${value}`);
			let field = form.getFieldMaybe(`${key}`);
			if(field && value){
				if(key == 'Case_Log') {
					form.getTextField(`${key}`).enableMultiline();
					form.getTextField(`${key}`).setFontSize(8);
					form.getTextField(`${key}`).setText(`${value}`);
				} else {
					form.getTextField(`${key}`).setText(`${value}`);
				}
			}
		}
	}

	// checkbox data
	if(checkboxdata) {
		for (const [key, value] of Object.entries(checkboxdata)) {
			let field = form.getFieldMaybe(`${key}`);
			if(field && value){
				if(value == 'On'){
					form.getCheckBox(`${key}`).check();
				}
			}
		}
	}

	// image data
	if(imgdata) {
		for (const [key, value] of Object.entries(imgdata)) {
			let embdedImage = '';
			let type = value.substring(value.indexOf('/') + 1, value.indexOf(';base64'));

			if(type == 'png') {
				// png
				embdedImage = await pdfDoc.embedPng(value);
			} else if(type == 'jpg' || type == 'jpeg') {
				// jpg
				embdedImage = await pdfDoc.embedJpg(value)
			}

			let field = form.getFieldMaybe(`${key}`);
			if(field && embdedImage){
				form.getTextField(`${key}`).setImage(embdedImage)
			}
		}
	}

	form.updateFieldAppearances(ubuntuFont);
	// Flatten the form's fields
	form.flatten();

	// Serialize the PDFDocument to bytes (a Uint8Array)
	const pdfBytes = await pdfDoc.save();
	fs.writeFileSync(output, await pdfDoc.save());
	
	console.log(output);
	return;
}

fillForm();
//module.exports.fillForm = fillForm;