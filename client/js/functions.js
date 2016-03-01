//variable
var urlServer='http://localhost/door2door/server/';
var urlMedia='http://localhost/door2door/server/img/';

var x = new XMLHttpRequest();
var display = true;

var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemer", "December"];

function menu()
{
  var nav = document.getElementById('divinfo');
  if (display){
    nav.style.left = '0';
    document.documentElement.style.overflow = 'hidden';
    document.body.scroll = "no";
    display =  false;
  }
  else {
    nav.style.left = '-100%';
    document.documentElement.style.overflow = 'auto';
    document.body.scroll = "yes";
    display =  true;
  }
}

function index()
{
	if(sessionStorage.token != null)
	{
		window.location = 'login.html';
	}
	else
	{
		window.location = 'login.html';
	}
}

function getuss()
{
  var us   = document.getElementById('user').value;
  var pass = document.getElementById('pass').value;
 /*----------------------------------------------------------------------*/
  x.open('GET', urlServer + 'getuser.php?user='+us+'&pass='+pass+'', true);
  x.send();
  x.onreadystatechange = function() {
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			console.log(data);
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//save info
        sessionStorage.usID = JSONdata.idUs;
        sessionStorage.nickName = JSONdata.nickName;
        console.log(sessionStorage.usID);
        console.log(sessionStorage.nickName);
        window.location.href = 'profile.html'
			}
			else
			{
				alert('Incorrect user or password');
			}
		}
  }
}

function onLoad()
{
	//set name in header
	var hname = document.getElementById('hname');
  hname.innerHTML = sessionStorage.nickName;
	//get page info
	getUserInfo();
}

function getUserInfo() 
{
  x.open('GET', urlServer + 'getperson.php?id='+sessionStorage.usID+'', true);
  x.send();
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//save info
				showInfo(JSONdata);
			}
			else
			{
				alert('Incorrect user or password-'+sessionStorage.usID);
			}
		}
  }
}

function showInfo(data)
{
	var content = document.getElementById('divPage');
	divPage.innerHTML = '';
	
	//create personal info div
	var hello = document.createElement('div');
	hello.setAttribute('id', 'hello');
	
	var helloText = document.createElement('div');
	helloText.setAttribute('id', 'hellotext');
	var helloTphone = document.createElement('p');
	helloTphone.innerHTML = 'Phone';
	var helloTemail = document.createElement('p');
	helloTemail.innerHTML = 'E-mail';
	
	helloText.appendChild(helloTphone);
	helloText.appendChild(helloTemail);
	
	var helloInput = document.createElement('div');
	helloInput.setAttribute('id', 'helloinput');
	
	var helloInPhone = document.createElement('input');
	helloInPhone.setAttribute('type', 'text');
	helloInPhone.setAttribute('id', 'phone');
	helloInPhone.value = data.phone;
	
	var helloInEmail = document.createElement('input');
	helloInEmail.setAttribute('type', 'text');
	helloInEmail.setAttribute('id', 'email');
	helloInEmail.value = data.email;
	
	var helloInButton = document.createElement('button');
	//helloInButton.style.text-align = 'right';
	helloInButton.innerHTML = 'Save';
	
	helloInput.appendChild(helloInPhone);
	helloInput.appendChild(helloInEmail);
	helloInput.appendChild(helloInButton);
	
	hello.appendChild(helloText);
	hello.appendChild(helloInput);
	
	//create residential info div
	var codes = document.createElement('div');
	codes.setAttribute('id', 'codes');
	
	var doorcode = document.createElement('div');
	doorcode.setAttribute('id', 'doorcode');
	var doorcodeText = document.createElement('div');
	doorcodeText.innerHTML = 'Your Door Code';
	var doorcodeNumber = document.createElement('h1');
	doorcodeNumber.setAttribute('id', 'AccessCode')
	getCode();
	
	doorcode.appendChild(doorcodeText);
	doorcode.appendChild(doorcodeNumber);
	
	var housenum = document.createElement('div');
	housenum.setAttribute('id', 'housenumber');
	var housenumText = document.createElement('div');
	housenumText.innerHTML = 'House Number';
	var housenumImg = document.createElement('img');
	housenumImg.src = urlMedia + 'house.png';
	var housenumNum = document.createElement('h1');
	housenumNum.innerHTML = data.house;
	
	housenum.appendChild(housenumText);
	housenum.appendChild(housenumImg);
	housenum.appendChild(housenumNum);
	
	codes.appendChild(doorcode);
	codes.appendChild(housenum);
	
	
	//Append information
	content.appendChild(hello);
	content.appendChild(codes);
	
	
	//Extra info to display
  var iname = document.getElementById('iname');
  iname.innerHTML = data.firstName + ' ' + data.lastName;
	//profile picture - get
  var photo = document.createElement('img');
  photo.src = urlMedia + 'prof/' + data.photo;
	//profile picture - set
  var imgprof = document.getElementById('imgprof');
	imgprof.innerHTML = '';
  imgprof.appendChild(photo);
}

function getCode()
{
	x.open('GET', urlServer + 'getaccesscode.php?id='+sessionStorage.usID, true);
  x.send();
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//save info
				showCode(JSONdata);
			}
			else
			{
				alert('Incorrect user or password-'+sessionStorage.usID);
			}
		}
  }
}

function showCode(data)
{
	var codeLabel = document.getElementById('AccessCode');
	codeLabel.innerHTML = data.accessCode;
}

function showPaymentsPage()
{
	//clear current content
	var content = document.getElementById('divPage');
	content.innerHTML = '';
	
	//-----------------------------------------------------------------------------------------------
	
	var nextPay = document.createElement('div');
	var nextPayText = document.createElement('label');
	nextPayText.setAttribute('id', 'nextPay');
	nextPay.appendChild(nextPayText);
	
	//-----------------------------------------------------------------------------------------------
	
	//create tabs
	var payments = document.createElement("div");
    payments.className = 'litlebutton';
	payments.innerHTML = "Payments";
	payments.setAttribute('onClick', 'getUserPayments();');
	
	var debts = document.createElement("div");
    debts.className = 'litlebutton';
	debts.innerHTML = "Debts"
	debts.setAttribute('onClick', 'getUserDebts();');
	
	//create page's content div
	var history = document.createElement("div");
	history.setAttribute("id", "divHistory");
	
	//append to page
	content.appendChild(nextPay);
	content.appendChild(payments);
	content.appendChild(debts);
	content.appendChild(history);
	
	//get next payment text
	nextPayText.innerHTML = getNextPayment();
	
	//get data
	getUserPayments();
}

function getNextPayment()
{
	//create new request not to interrupt other request
	var x2 = new XMLHttpRequest();
	x2.open('GET', urlServer + 'getnextpayment.php', true);
  x2.send();
  x2.onreadystatechange = function(){
    //check status
		if (x2.readyState == 4 & x2.status == 200)
		{
			//read response
			var data = x2.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//show info
				parseNextPayment(JSONdata);
			}
			else
			{
				alert('An error has occured. Check your internet connection');
			}
		}
  }
}

function parseNextPayment(data)
{
	var result = '';
	result += 'Month: ' + parseDate(data.periodDate);
	result += ', Amount: ' + data.amount;
	
	showNextPayment(result)
}

function showNextPayment(text)
{
	var nextPay = document.getElementById('nextPay');
	nextPay.innerHTML = text;
}

function getUserPayments()
{
	x.open('GET', urlServer + 'getpersonpayments.php?txtid=' + sessionStorage.usID, true);
  x.send();
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//show info
				//console.log(JSONdata);
				showPayments(JSONdata, 1);
			}
			else
			{
				alert('An error has occured. Check your internet connection');
			}
		}
  }
}

function getUserDebts()
{
	x.open('GET', urlServer + 'getpersondebts.php?txtid=' + sessionStorage.usID, true);
  x.send();
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//show info
				console.log(JSONdata);
				showPayments(JSONdata, 2);
				
			}
			else
			{
				alert('An error has occured. Check your internet connection');
			}
		}
  }
}

function showPayments(data, tab)
{
	var content = document.getElementById('divHistory');
	content.innerHTML = "";
	
	var valueArray = [];
	switch(tab)
	{
		case 1:
			valueArray = data.payments;
			break;
		case 2:
			valueArray = data.debts;
			break;
		default:
			break;
	}
	//tabla, luego pasar a divs con estilos
	var tablecont = document.createElement('div');
    tablecont.className = 'tablecont';
	var table = document.createElement('table');
    table.className = 'table';
	var heads = document.createElement('tr');
	
	var thId = document.createElement('th');
	thId.innerHTML = 'Id';
	var thDate = document.createElement('th');
	thDate.innerHTML = 'Period';
	var thAmount = document.createElement('th');
	thAmount.innerHTML = 'Amount';
	var thType = document.createElement('th');
	thType.innerHTML = 'Payment Type';
	var thRate = document.createElement('th');
	thRate.innerHTML = 'Interest Rate';
	var thOrigAmnt = document.createElement('th');
	thOrigAmnt.innerHTML = 'Original Amount';
	
	heads.appendChild(thId);
	heads.appendChild(thDate);
	heads.appendChild(thAmount);
	if(tab == 1) heads.appendChild(thType);
	heads.appendChild(thRate);
	heads.appendChild(thOrigAmnt);
	
	table.appendChild(heads);
	
	for(var i = 0; i < valueArray.length; i++)
	{
		var value = valueArray[i];
		
		var row = document.createElement('tr');
		
		var tdId = document.createElement('td');
		tdId.innerHTML = value.id;
		
		var tdDate = document.createElement('td');
		tdDate.innerHTML = parseDate(value.period.date);
		
		var tdAmount = document.createElement('td');
		tdAmount.innerHTML = value.amount;
		
		var tdType = document.createElement('td');
		var tdRate = document.createElement('td');
		var tdOrigAmnt = document.createElement('td');
		
		var payType = '';
		if(parseInt(value.isDebt) || tab == 2)
		{
			payType = 'Debt Payment';
			//if payment is for debt, display ratio and base price
			tdRate.innerHTML = value.period.debtRate;
			tdOrigAmnt.innerHTML = value.period.amount;
		}
		else
		{
			//if it's not debt, don't display extras
			payType = 'Regular Payment';
		}
		
		tdType.innerHTML = payType;
		
		//append cells to row
		row.appendChild(tdId);
		row.appendChild(tdDate);
		row.appendChild(tdAmount);
		if(tab == 1) row.appendChild(tdType);
		row.appendChild(tdRate);
		row.appendChild(tdOrigAmnt);
		
		//append row to table
		table.appendChild(row);
	}
	tablecont.appendChild(table);
	content.appendChild(tablecont);
}

function getSpendReportPeriods()
{
	x.open('POST', urlServer + 'getperiods.php', true);
  x.send();
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//show info
				showSpendReportPage(JSONdata);
			}
			else
			{
				alert('An error has occured. Check your internet connection');
			}
		}
  }
}

function showSpendReportPage(data)
{
	var content = document.getElementById('divPage');
	content.innerHTML = '';
	
	var divHeader = document.createElement('div');
	var cmbPeriods = document.createElement('select');
	cmbPeriods.setAttribute('onchange', 'getSpendingsReport(this.value)');
	
	divHeader.appendChild(cmbPeriods);
	
	var divSpends = document.createElement('div');
	divSpends.setAttribute('id', 'spendings');
	
	var divPays = document.createElement('div');
	divPays.setAttribute('id', 'payments');
	
	var divTotal = document.createElement('div');
	divTotal.setAttribute('id', 'total');
	
	divHeader.style.width = '100%';
	divSpends.style.width = '100%';
	divPays.style.width = '100%';
	divTotal.style.width = '100%';
	
	content.appendChild(divHeader);
	content.appendChild(divSpends);
	content.appendChild(divPays);
	content.appendChild(divTotal);
	
	cmbPeriods.appendChild(document.createElement('option'));
	var periods = data.periods;
	for(var i = 0; i < periods.length; i++)
	{
		var option = document.createElement('option');
		
		option.value = periods[i].id;
		option.text = parseDate(periods[i].date);
		
		cmbPeriods.appendChild(option);
	}
}

function getSpendingsReport(PeriodId)
{
	x.open('POST', urlServer + 'getperiodreport.php', true);
	var data = new FormData();
	console.log(PeriodId);
	data.append('period', PeriodId);
  x.send(data);
  x.onreadystatechange = function(){
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			console.log(data);
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//show info
				showSpendReport(JSONdata);
			}
			else
			{
				alert('An error has occured. Check your internet connection');
			}
		}
  }
}

function showSpendReport(data)
{
	var payments = document.getElementById('payments');
	var spendings = document.getElementById('spendings');
	var total = document.getElementById('total');
	
	payments.innerHTML = '';
	spendings.innerHTML = '';
	total.innerHTML = '';
	
	var paystable = document.createElement('table');
	var spnstable = document.createElement('table');
	var totltable = document.createElement('table');
	
	payments.appendChild(paystable);
	spendings.appendChild(spnstable);
	total.appendChild(totltable);
	
	var spnArray = data.spendings;
	for(var i = 0; i < spnArray.length; i++)
	{
		var row = document.createElement('tr');
		
		var tdId = document.createElement('td');
		tdId.innerHTML = spnArray[i].id;
		
		var tdAmount = document.createElement('td');
		tdAmount.innerHTML = spnArray[i].amount;
		
		var tdServName = document.createElement('td');
		tdServName.innerHTML = spnArray[i].service.name;
		
		var tdServDesc = document.createElement('td');
		tdServDesc.innerHTML = spnArray[i].service.description;
		
		row.appendChild(tdId);
		row.appendChild(tdAmount);
		row.appendChild(tdServName);
		row.appendChild(tdServDesc);
		
		spnstable.appendChild(row);
	}
	
	var payArray = data.payments;
	for(var i = 0; i < payArray.length; i++)
	{
		var row = document.createElement('tr');
		
		var tdId = document.createElement('td');
		tdId.innerHTML = payArray[i].id;
		
		var tdAmount = document.createElement('td');
		tdAmount.innerHTML = payArray[i].amount;
		
		var tdType = document.createElement('td');
		if(parseInt(payArray[i].isDebt))
			tdType.innerHTML = 'Debt Payment';
		else
			tdType.innerHTML = 'Regular Payment';
		
		var tdResident = document.createElement('td');
		tdResident.innerHTML = payArray[i].resident.firstName + ' ' + payArray[i].resident.lastName;
		
		row.appendChild(tdId);
		row.appendChild(tdAmount);
		row.appendChild(tdType);
		row.appendChild(tdResident);
		
		paystable.appendChild(row);
	}
	
	var totalPays = document.createElement('td');
	totalPays.innerHTML = data.subtotalPayments;
	
	var totalSpnd = document.createElement('td');
	totalSpnd.innerHTML = data.subtotalSpendings;
	
	var grandTotal = document.createElement('td');
	grandTotal.innerHTML = data.total;
	
	totltable.appendChild(totalPays);
	totltable.appendChild(totalSpnd);
	totltable.appendChild(grandTotal);
}



function parseDate(origDate)
{
	//get date from DB date string
	var date = origDate.substring(0,10);
	//get first two digits (date ommited because of proyect)
	gottenDate = date.split("-", 2);
	//prepare 'readable' date string
	var readyDate = monthNames[parseInt(gottenDate[1]) - 1] + ' ' + gottenDate[0];
	//return readable date
	return readyDate;
}