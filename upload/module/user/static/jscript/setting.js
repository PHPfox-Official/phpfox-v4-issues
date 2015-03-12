var sSetTimeZone = null;

function findTZFromLocation(bSkip)
{
	if (sSetTimeZone != undefined && bSkip != true)
	{
		var iIndex = 0;
		$('select#time_zone option').each(function(iIndex){

			if ($(this).val() == sSetTimeZone)
			{
				$('select#time_zone').attr('selectedIndex', iIndex);
				return;
			}
			iIndex++;
		});
	}
	else
	{
		// get the selected value in the location
		var sISO = $('select#country_iso option:selected').text();
		// loop through the available time zones
		var bShow = true;
		$('select#time_zone option').each(function(iIndex){
			if ((-1) < $(this).text().replace(' ', '_').indexOf(sISO.replace(' ', '_')))
			{
				// select this one
				$('select#time_zone').attr('selectedIndex', iIndex);
				bShow = false;
				return false;
			}
			return true;
		});
		if (bShow)
		{
			$('select#time_zone').attr('selectedIndex', 0);
		}
	}
}

$(document).ready(function(){
	findTZFromLocation();
	$('select#country_iso').change(function(){findTZFromLocation(true)});
});

