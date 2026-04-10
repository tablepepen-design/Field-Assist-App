/**
 * Google Apps Script to sync data between Google Sheets and Field Assist App
 * 
 * Instructions:
 * 1. Open your Google Sheet.
 * 2. Go to Extensions > Apps Script.
 * 3. Delete any code in the editor and paste this code.
 * 4. Update the WEB_APP_URL below to your hosted project URL.
 * 5. Click "Deploy" > "New Deployment".
 * 6. Select "Web App".
 * 7. Set "Execute as" to "Me" and "Who has access" to "Anyone".
 * 8. Copy the Web App URL and paste it in the app's config.php.
 */

const WEB_APP_URL = 'https://your-domain.com/api/sync_sheet.php'; 
const API_KEY = 'MORARKA_SYNC_2026';

/**
 * PUSH: Sends data to the PHP app (Manual or Triggered)
 */
function syncData() {
  const payload = getSheetDataJson();
  if (!payload) return;
  
  const options = {
    method: 'post',
    contentType: 'application/json',
    payload: JSON.stringify(payload),
    headers: { 'X-API-KEY': API_KEY },
    muteHttpExceptions: true
  };
  
  try {
    const response = UrlFetchApp.fetch(WEB_APP_URL, options);
    const result = response.getContentText();
    SpreadsheetApp.getUi().alert('Sync Result: ' + result);
  } catch (e) {
    SpreadsheetApp.getUi().alert('Error: ' + e.toString());
  }
}

/**
 * PULL: Returns data as JSON when the Web App URL is visited
 */
function doGet(e) {
  const data = getSheetDataJson();
  return ContentService.createTextOutput(JSON.stringify(data))
    .setMimeType(ContentService.MimeType.JSON);
}

function getSheetDataJson() {
  const sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  const data = sheet.getDataRange().getValues();
  const rows = data.slice(1);
  const payload = [];
  
  for (let i = 0; i < rows.length; i++) {
    const row = rows[i];
    if (row[0] === 'Totals' || !row[0]) break;
    
    payload.push({
      date: row[0],
      salesman: row[1],
      item_number: row[2],
      shop_name: row[3],
      product: row[4],
      units: row[5],
      unit_price: row[6],
      sales_amount: row[7],
      totals: row[8]
    });
  }
  return payload;
}

function onOpen() {
  const ui = SpreadsheetApp.getUi();
  ui.createMenu('Field Assist Sync')
      .addItem('Sync to App Now', 'syncData')
      .addToUi();
}
