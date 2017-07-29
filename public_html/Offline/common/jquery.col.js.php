<?php
//dezend by http://www.yunlu99.com/
echo '/*' . "\r\n" . ' * jQuery columnManager plugin' . "\r\n" . ' * Version: 0.2.5' . "\r\n" . ' *' . "\r\n" . ' * Copyright (c) 2007 Roman Weich' . "\r\n" . ' * http://p.sohei.org' . "\r\n" . ' *' . "\r\n" . ' * Dual licensed under the MIT and GPL licenses ' . "\r\n" . ' * (This means that you can choose the license that best suits your project, and use it accordingly):' . "\r\n" . ' *   http://www.opensource.org/licenses/mit-license.php' . "\r\n" . ' *   http://www.gnu.org/licenses/gpl.html' . "\r\n" . ' *' . "\r\n" . ' * Changelog: ' . "\r\n" . ' * v 0.2.5 - 2008-01-17' . "\r\n" . ' *	-change: added options "show" and "hide". with these functions the user can control the way to show or hide the cells' . "\r\n" . ' *	-change: added $.fn.showColumns() and $.fn.hideColumns which allows to explicitely show or hide any given number of columns' . "\r\n" . ' * v 0.2.4 - 2007-12-02' . "\r\n" . ' *	-fix: a problem with the on/off css classes when manually toggling columns which were not in the column header list' . "\r\n" . ' *	-fix: an error in the createColumnHeaderList function incorectly resetting the visibility state of the columns' . "\r\n" . ' *	-change: restructured some of the code' . "\r\n" . ' * v 0.2.3 - 2007-12-02' . "\r\n" . ' *	-change: when a column header has no text but some html markup as content, the markup is used in the column header list instead of "undefined"' . "\r\n" . ' * v 0.2.2 - 2007-11-27' . "\r\n" . ' *	-change: added the ablity to change the on and off CSS classes in the column header list through $().toggleColumns()' . "\r\n" . ' *	-change: to avoid conflicts with other plugins, the table-referencing data in the column header list is now stored as an expando and not in the class name as before' . "\r\n" . ' * v 0.2.1 - 2007-08-14' . "\r\n" . ' *	-fix: handling of colspans didn\'t work properly for the very first spanning column' . "\r\n" . ' *	-change: altered the cookie handling routines for easier management' . "\r\n" . ' * v 0.2.0 - 2007-04-14' . "\r\n" . ' *	-change: supports tables with colspanned and rowspanned cells now' . "\r\n" . ' * v 0.1.4 - 2007-04-11' . "\r\n" . ' *	-change: added onToggle option to specify a custom callback function for the toggling over the column header list' . "\r\n" . ' * v 0.1.3 - 2007-04-05' . "\r\n" . ' *	-fix: bug when saving the value in a cookie' . "\r\n" . ' *	-change: toggleColumns takes a number or an array of numbers as argument now' . "\r\n" . ' * v 0.1.2 - 2007-04-02' . "\r\n" . ' * 	-change: added jsDoc style documentation and examples' . "\r\n" . ' * 	-change: the column index passed to toggleColumns() starts at 1 now (conforming to the values passed in the hideInList and colsHidden options)' . "\r\n" . ' * v 0.1.1 - 2007-03-30' . "\r\n" . ' * 	-change: changed hideInList and colsHidden options to hold integer values for the column indexes to be affected' . "\r\n" . ' *	-change: made the toggleColumns function accessible through the jquery object, to toggle the state without the need for the column header list' . "\r\n" . ' *	-fix: error when not finding the passed listTargetID in the dom' . "\r\n" . ' * v 0.1.0 - 2007-03-27' . "\r\n" . ' */' . "\r\n" . '' . "\r\n" . '(function($) ' . "\r\n" . '{' . "\r\n" . '	var defaults = {' . "\r\n" . '		listTargetID : null,' . "\r\n" . '		onClass : \'\',' . "\r\n" . '		offClass : \'\',' . "\r\n" . '		hideInList: [],' . "\r\n" . '		colsHidden: [],' . "\r\n" . '		saveState: false,' . "\r\n" . '		onToggle: null,' . "\r\n" . '		show: function(cell){' . "\r\n" . '			showCell(cell);' . "\r\n" . '		},' . "\r\n" . '		hide: function(cell){' . "\r\n" . '			hideCell(cell);' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '	' . "\r\n" . '	var idCount = 0;' . "\r\n" . '	var cookieName = \'columnManagerC\';' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Saves the current state for the table in a cookie.' . "\r\n" . '	 * @param {element} table	The table for which to save the current state.' . "\r\n" . '	 */' . "\r\n" . '	var saveCurrentValue = function(table)' . "\r\n" . '	{' . "\r\n" . '		var val = \'\', i = 0, colsVisible = table.cMColsVisible;' . "\r\n" . '		if ( table.cMSaveState && table.id && colsVisible && $.cookie )' . "\r\n" . '		{' . "\r\n" . '			for ( ; i < colsVisible.length; i++ )' . "\r\n" . '			{' . "\r\n" . '				val += ( colsVisible[i] == false ) ? 0 : 1;' . "\r\n" . '			}' . "\r\n" . '			$.cookie(cookieName + table.id, val, {expires: 9999});' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '	' . "\r\n" . '	/**' . "\r\n" . '	 * Hides a cell.' . "\r\n" . '	 * It rewrites itself after the browsercheck!' . "\r\n" . '	 * @param {element} cell	The cell to hide.' . "\r\n" . '	 */' . "\r\n" . '	var hideCell = function(cell)' . "\r\n" . '	{' . "\r\n" . '		if ( jQuery.browser.msie )' . "\r\n" . '		{' . "\r\n" . '			(hideCell = function(c)' . "\r\n" . '			{' . "\r\n" . '				c.style.setAttribute(\'display\', \'none\');' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			(hideCell = function(c)' . "\r\n" . '			{' . "\r\n" . '				c.style.display = \'none\';' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Makes a cell visible again.' . "\r\n" . '	 * It rewrites itself after the browsercheck!' . "\r\n" . '	 * @param {element} cell	The cell to show.' . "\r\n" . '	 */' . "\r\n" . '	var showCell = function(cell)' . "\r\n" . '	{' . "\r\n" . '		if ( jQuery.browser.msie )' . "\r\n" . '		{' . "\r\n" . '			(showCell = function(c)' . "\r\n" . '			{' . "\r\n" . '				c.style.setAttribute(\'display\', \'block\');' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			(showCell = function(c)' . "\r\n" . '			{' . "\r\n" . '				c.style.display = \'table-cell\';' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Returns the visible state of a cell.' . "\r\n" . '	 * It rewrites itself after the browsercheck!' . "\r\n" . '	 * @param {element} cell	The cell to test.' . "\r\n" . '	 */' . "\r\n" . '	var cellVisible = function(cell)' . "\r\n" . '	{' . "\r\n" . '		if ( jQuery.browser.msie )' . "\r\n" . '		{' . "\r\n" . '			return (cellVisible = function(c)' . "\r\n" . '			{' . "\r\n" . '				return c.style.getAttribute(\'display\') != \'none\';' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '		else' . "\r\n" . '		{' . "\r\n" . '			return (cellVisible = function(c)' . "\r\n" . '			{' . "\r\n" . '				return c.style.display != \'none\';' . "\r\n" . '			})(cell);' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Returns the cell element which has the passed column index value.' . "\r\n" . '	 * @param {element} table	The table element.' . "\r\n" . '	 * @param {array} cells		The cells to loop through.' . "\r\n" . '	 * @param {integer} col	The column index to look for.' . "\r\n" . '	 */' . "\r\n" . '	var getCell = function(table, cells, col)' . "\r\n" . '	{' . "\r\n" . '		for ( var i = 0; i < cells.length; i++ )' . "\r\n" . '		{' . "\r\n" . '			if ( cells[i].realIndex === undefined ) //the test is here, because rows/cells could get added after the first run' . "\r\n" . '			{' . "\r\n" . '				fixCellIndexes(table);' . "\r\n" . '			}' . "\r\n" . '			if ( cells[i].realIndex == col )' . "\r\n" . '			{' . "\r\n" . '				return cells[i];' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '		return null;' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Calculates the actual cellIndex value of all cells in the table and stores it in the realCell property of each cell.' . "\r\n" . '	 * Thats done because the cellIndex value isn\'t correct when colspans or rowspans are used.' . "\r\n" . '	 * Originally created by Matt Kruse for his table library - Big Thanks! (see http://www.javascripttoolbox.com/)' . "\r\n" . '	 * @param {element} table	The table element.' . "\r\n" . '	 */' . "\r\n" . '	var fixCellIndexes = function(table) ' . "\r\n" . '	{' . "\r\n" . '		var rows = table.rows;' . "\r\n" . '		var len = rows.length;' . "\r\n" . '		var matrix = [];' . "\r\n" . '		for ( var i = 0; i < len; i++ )' . "\r\n" . '		{' . "\r\n" . '			var cells = rows[i].cells;' . "\r\n" . '			var clen = cells.length;' . "\r\n" . '			for ( var j = 0; j < clen; j++ )' . "\r\n" . '			{' . "\r\n" . '				var c = cells[j];' . "\r\n" . '				var rowSpan = c.rowSpan || 1;' . "\r\n" . '				var colSpan = c.colSpan || 1;' . "\r\n" . '				var firstAvailCol = -1;' . "\r\n" . '				if ( !matrix[i] )' . "\r\n" . '				{ ' . "\r\n" . '					matrix[i] = []; ' . "\r\n" . '				}' . "\r\n" . '				var m = matrix[i];' . "\r\n" . '				// Find first available column in the first row' . "\r\n" . '				while ( m[++firstAvailCol] ) {}' . "\r\n" . '				c.realIndex = firstAvailCol;' . "\r\n" . '				for ( var k = i; k < i + rowSpan; k++ )' . "\r\n" . '				{' . "\r\n" . '					if ( !matrix[k] )' . "\r\n" . '					{ ' . "\r\n" . '						matrix[k] = []; ' . "\r\n" . '					}' . "\r\n" . '					var matrixrow = matrix[k];' . "\r\n" . '					for ( var l = firstAvailCol; l < firstAvailCol + colSpan; l++ )' . "\r\n" . '					{' . "\r\n" . '						matrixrow[l] = 1;' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '		}' . "\r\n" . '	};' . "\r\n" . '	' . "\r\n" . '	/**' . "\r\n" . '	 * Manages the column display state for a table.' . "\r\n" . '	 *' . "\r\n" . '	 * Features:' . "\r\n" . '	 * Saves the state and recreates it on the next visit of the site (requires cookie-plugin).' . "\r\n" . '	 * Extracts all headers and builds an unordered(<UL>) list out of them, where clicking an list element will show/hide the matching column.' . "\r\n" . '	 *' . "\r\n" . '	 * @param {map} options		An object for optional settings (options described below).' . "\r\n" . '	 *' . "\r\n" . '	 * @option {string} listTargetID	The ID attribute of the element the column header list will be added to.' . "\r\n" . '	 *						Default value: null' . "\r\n" . '	 * @option {string} onClass		A CSS class that is used on the items in the column header list, for which the column state is visible ' . "\r\n" . '	 *						Works only with listTargetID set!' . "\r\n" . '	 *						Default value: \'\'' . "\r\n" . '	 * @option {string} offClass		A CSS class that is used on the items in the column header list, for which the column state is hidden.' . "\r\n" . '	 *						Works only with listTargetID set!' . "\r\n" . '	 *						Default value: \'\'' . "\r\n" . '	 * @option {array} hideInList	An array of numbers. Each column with the matching column index won\'t be displayed in the column header list.' . "\r\n" . '	 *						Index starting at 1!' . "\r\n" . '	 *						Default value: [] (all columns will be included in the list)' . "\r\n" . '	 * @option {array} colsHidden	An array of numbers. Each column with the matching column index will get hidden by default.' . "\r\n" . '	 *						The value is overwritten when saveState is true and a cookie is set for this table.' . "\r\n" . '	 *						Index starting at 1!' . "\r\n" . '	 *						Default value: []' . "\r\n" . '	 * @option {boolean} saveState	Save a cookie with the sate information of each column.' . "\r\n" . '	 *						Requires jQuery cookie plugin.' . "\r\n" . '	 *						Default value: false' . "\r\n" . '	 * @option {function} onToggle	Callback function which is triggered when the visibility state of a column was toggled through the column header list.' . "\r\n" . '	 *						The passed parameters are: the column index(integer) and the visibility state(boolean).' . "\r\n" . '	 *						Default value: null' . "\r\n" . '	 *' . "\r\n" . '	 * @option {function} show		Function which is called to show a table cell.' . "\r\n" . '	 *						The passed parameters are: the table cell (DOM-element).' . "\r\n" . '	 *						Default value: a functions which simply sets the display-style to block (visible)' . "\r\n" . '	 *' . "\r\n" . '	 * @option {function} hide		Function which is called to hide a table cell.' . "\r\n" . '	 *						The passed parameters are: the table cell (DOM-element).' . "\r\n" . '	 *						Default value: a functions which simply sets the display-style to none (invisible)' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').columnManager([listTargetID: "target", onClass: "on", offClass: "off"]);' . "\r\n" . '	 * @desc Creates the column header list in the element with the ID attribute "target" and sets the CSS classes for the visible("on") and hidden("off") states.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').columnManager([listTargetID: "target", hideInList: [1, 4]]);' . "\r\n" . '	 * @desc Creates the column header list in the element with the ID attribute "target" but without the first and fourth column.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').columnManager([listTargetID: "target", colsHidden: [1, 4]]);' . "\r\n" . '	 * @desc Creates the column header list in the element with the ID attribute "target" and hides the first and fourth column by default.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').columnManager([saveState: true]);' . "\r\n" . '	 * @desc Enables the saving of visibility informations for the columns. Does not create a column header list! Toggle the columns visiblity through $(\'selector\').toggleColumns().' . "\r\n" . '	 *' . "\r\n" . '	 * @type jQuery' . "\r\n" . '	 *' . "\r\n" . '	 * @name columnManager' . "\r\n" . '	 * @cat Plugins/columnManager' . "\r\n" . '	 * @author Roman Weich (http://p.sohei.org)' . "\r\n" . '	 */' . "\r\n" . '	$.fn.columnManager = function(options)' . "\r\n" . '	{' . "\r\n" . '		var settings = $.extend({}, defaults, options);' . "\r\n" . '' . "\r\n" . '		/**' . "\r\n" . '		 * Creates the column header list.' . "\r\n" . '		 * @param {element} table	The table element for which to create the list.' . "\r\n" . '		 */' . "\r\n" . '		var createColumnHeaderList = function(table)' . "\r\n" . '		{' . "\r\n" . '			if ( !settings.listTargetID )' . "\r\n" . '			{' . "\r\n" . '				return;' . "\r\n" . '			}' . "\r\n" . '			var $target = $(\'#\' + settings.listTargetID);' . "\r\n" . '			if ( !$target.length )' . "\r\n" . '			{' . "\r\n" . '				return;' . "\r\n" . '			}' . "\r\n" . '			//select headrow - when there is no thead-element, use the first row in the table' . "\r\n" . '			var headRow = null;' . "\r\n" . '			if ( table.tHead && table.tHead.length )' . "\r\n" . '			{' . "\r\n" . '				headRow = table.tHead.rows[0];' . "\r\n" . '			}' . "\r\n" . '			else if ( table.rows.length )' . "\r\n" . '			{' . "\r\n" . '				headRow = table.rows[0];' . "\r\n" . '			}' . "\r\n" . '			else' . "\r\n" . '			{' . "\r\n" . '				return; //no header - nothing to do' . "\r\n" . '			}' . "\r\n" . '			var cells = headRow.cells;' . "\r\n" . '			if ( !cells.length )' . "\r\n" . '			{' . "\r\n" . '				return; //no header - nothing to do' . "\r\n" . '			}' . "\r\n" . '			//create list in target element' . "\r\n" . '			var $list = null;' . "\r\n" . '			if ( $target.get(0).nodeName.toUpperCase() == \'UL\' )' . "\r\n" . '			{' . "\r\n" . '				$list = $target;' . "\r\n" . '			}' . "\r\n" . '			else' . "\r\n" . '			{' . "\r\n" . '				$list = $(\'<ul></ul>\');' . "\r\n" . '				$target.append($list);' . "\r\n" . '			}' . "\r\n" . '			var colsVisible = table.cMColsVisible;' . "\r\n" . '			//create list elements from headers' . "\r\n" . '			for ( var i = 0; i < cells.length; i++ )' . "\r\n" . '			{' . "\r\n" . '				if ( $.inArray(i + 1, settings.hideInList) >= 0 )' . "\r\n" . '				{' . "\r\n" . '					continue;' . "\r\n" . '				}' . "\r\n" . '				colsVisible[i] = ( colsVisible[i] !== undefined ) ? colsVisible[i] : true;' . "\r\n" . '				var text = $(cells[i]).text(), ' . "\r\n" . '					addClass;' . "\r\n" . '				if ( !text.length )' . "\r\n" . '				{' . "\r\n" . '					text = $(cells[i]).html();' . "\r\n" . '					if ( !text.length ) //still nothing?' . "\r\n" . '					{' . "\r\n" . '						text = \'undefined\';' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '				if ( colsVisible[i] && settings.onClass )' . "\r\n" . '				{' . "\r\n" . '					addClass = settings.onClass;' . "\r\n" . '				}' . "\r\n" . '				else if ( !colsVisible[i] && settings.offClass )' . "\r\n" . '				{' . "\r\n" . '					addClass = settings.offClass;' . "\r\n" . '				}' . "\r\n" . '				var $li = $(\'<li class="\' + addClass + \'">\' + text + \'</li>\').click(toggleClick);' . "\r\n" . '				$li[0].cmData = {id: table.id, col: i};' . "\r\n" . '				$list.append($li);' . "\r\n" . '			}' . "\r\n" . '			table.cMColsVisible = colsVisible;' . "\r\n" . '		};' . "\r\n" . '' . "\r\n" . '		/**' . "\r\n" . '		 * called when an item in the column header list is clicked' . "\r\n" . '		 */' . "\r\n" . '		var toggleClick = function()' . "\r\n" . '		{' . "\r\n" . '			//get table id and column name' . "\r\n" . '			var data = this.cmData;' . "\r\n" . '			if ( data && data.id && data.col >= 0 )' . "\r\n" . '			{' . "\r\n" . '				var colNum = data.col, ' . "\r\n" . '					$table = $(\'#\' + data.id);' . "\r\n" . '				if ( $table.length )' . "\r\n" . '				{' . "\r\n" . '					$table.toggleColumns([colNum + 1], settings);' . "\r\n" . '					//set the appropriate classes to the column header list' . "\r\n" . '					var colsVisible = $table.get(0).cMColsVisible;' . "\r\n" . '					if ( settings.onToggle )' . "\r\n" . '					{' . "\r\n" . '						settings.onToggle.apply($table.get(0), [colNum + 1, colsVisible[colNum]]);' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '		};' . "\r\n" . '' . "\r\n" . '		/**' . "\r\n" . '		 * Reads the saved state from the cookie.' . "\r\n" . '		 * @param {string} tableID	The ID attribute from the table.' . "\r\n" . '		 */' . "\r\n" . '		var getSavedValue = function(tableID)' . "\r\n" . '		{' . "\r\n" . '			var val = $.cookie(cookieName + tableID);' . "\r\n" . '			if ( val )' . "\r\n" . '			{' . "\r\n" . '				var ar = val.split(\'\');' . "\r\n" . '				for ( var i = 0; i < ar.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					ar[i] &= 1;' . "\r\n" . '				}' . "\r\n" . '				return ar;' . "\r\n" . '			}' . "\r\n" . '			return false;' . "\r\n" . '		};' . "\r\n" . '' . "\r\n" . '        return this.each(function()' . "\r\n" . '        {' . "\r\n" . '			this.id = this.id || \'jQcM0O\' + idCount++; //we need an id for the column header list stuff' . "\r\n" . '			var i, ' . "\r\n" . '				colsHide = [], ' . "\r\n" . '				colsVisible = [];' . "\r\n" . '			//fix cellIndex values' . "\r\n" . '			fixCellIndexes(this);' . "\r\n" . '			//some columns hidden by default?' . "\r\n" . '			if ( settings.colsHidden.length )' . "\r\n" . '			{' . "\r\n" . '				for ( i = 0; i < settings.colsHidden.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					colsVisible[settings.colsHidden[i] - 1] = true;' . "\r\n" . '					colsHide[settings.colsHidden[i] - 1] = true;' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '			//get saved state - and overwrite defaults' . "\r\n" . '			if ( settings.saveState )' . "\r\n" . '			{' . "\r\n" . '				var colsSaved = getSavedValue(this.id);' . "\r\n" . '				if ( colsSaved && colsSaved.length )' . "\r\n" . '				{' . "\r\n" . '					for ( i = 0; i < colsSaved.length; i++ )' . "\r\n" . '					{' . "\r\n" . '						colsVisible[i] = true;' . "\r\n" . '						colsHide[i] = !colsSaved[i];' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '				this.cMSaveState = true;' . "\r\n" . '			}' . "\r\n" . '			//assign initial colsVisible var to the table (needed for toggling and saving the state)' . "\r\n" . '			this.cMColsVisible = colsVisible;' . "\r\n" . '			//something to hide already?' . "\r\n" . '			if ( colsHide.length )' . "\r\n" . '			{' . "\r\n" . '				var a = [];' . "\r\n" . '				for ( i = 0; i < colsHide.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					if ( colsHide[i] )' . "\r\n" . '					{' . "\r\n" . '						a[a.length] = i + 1;' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '				if ( a.length )' . "\r\n" . '				{' . "\r\n" . '					$(this).toggleColumns(a);' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '			//create column header list' . "\r\n" . '			createColumnHeaderList(this);' . "\r\n" . '        }); ' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Shows or hides table columns.' . "\r\n" . '	 *' . "\r\n" . '	 * @param {integer|array} columns		A number or an array of numbers. The display state(visible/hidden) for each column with the matching column index will get toggled.' . "\r\n" . '	 *							Column index starts at 1! (see the example)' . "\r\n" . '	 *' . "\r\n" . '	 * @param {map} options		An object for optional settings to handle the on and off CSS classes in the column header list (options described below).' . "\r\n" . '	 * @option {string} listTargetID	The ID attribute of the element with the column header.' . "\r\n" . '	 * @option {string} onClass		A CSS class that is used on the items in the column header list, for which the column state is visible ' . "\r\n" . '	 * @option {string} offClass		A CSS class that is used on the items in the column header list, for which the column state is hidden.' . "\r\n" . '	 * @option {function} show		Function which is called to show a table cell.' . "\r\n" . '	 * @option {function} hide		Function which is called to hide a table cell.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').toggleColumns([2, 4], {hide: function(cell) { $(cell).fadeOut("slow"); }});' . "\r\n" . '	 * @before <table id="table">' . "\r\n" . '	 *   			<thead>' . "\r\n" . '	 *   				<th>one</th' . "\r\n" . '	 *   				<th>two</th' . "\r\n" . '	 *   				<th>three</th' . "\r\n" . '	 *   				<th>four</th' . "\r\n" . '	 *   			</thead>' . "\r\n" . '	 * 		   </table>' . "\r\n" . '	 * @desc Toggles the visible state for the columns "two" and "four". Use custom function to fade the cell out when hiding it.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').toggleColumns(3, {listTargetID: \'theID\', onClass: \'vis\'});' . "\r\n" . '	 * @before <table id="table">' . "\r\n" . '	 *   			<thead>' . "\r\n" . '	 *   				<th>one</th' . "\r\n" . '	 *   				<th>two</th' . "\r\n" . '	 *   				<th>three</th' . "\r\n" . '	 *   				<th>four</th' . "\r\n" . '	 *   			</thead>' . "\r\n" . '	 * 		   </table>' . "\r\n" . '	 * @desc Toggles the visible state for column "three" and sets or removes the CSS class \'vis\' to the appropriate column header according to the visibility of the column.' . "\r\n" . '	 *' . "\r\n" . '	 * @type jQuery' . "\r\n" . '	 *' . "\r\n" . '	 * @name toggleColumns' . "\r\n" . '	 * @cat Plugins/columnManager' . "\r\n" . '	 * @author Roman Weich (http://p.sohei.org)' . "\r\n" . '	 */' . "\r\n" . '	$.fn.toggleColumns = function(columns, cmo)' . "\r\n" . '	{' . "\r\n" . '        return this.each(function() ' . "\r\n" . '        {' . "\r\n" . '			var i, toggle, di, ' . "\r\n" . '				rows = this.rows, ' . "\r\n" . '				colsVisible = this.cMColsVisible;' . "\r\n" . '' . "\r\n" . '			if ( !columns )' . "\r\n" . '				return;' . "\r\n" . '' . "\r\n" . '			if ( columns.constructor == Number )' . "\r\n" . '				columns = [columns];' . "\r\n" . '' . "\r\n" . '			if ( !colsVisible )' . "\r\n" . '				colsVisible = this.cMColsVisible = [];' . "\r\n" . '' . "\r\n" . '			//go through all rows in the table and hide the cells' . "\r\n" . '			for ( i = 0; i < rows.length; i++ )' . "\r\n" . '			{' . "\r\n" . '				var cells = rows[i].cells;' . "\r\n" . '				for ( var k = 0; k < columns.length; k++ )' . "\r\n" . '				{' . "\r\n" . '					var col = columns[k] - 1;' . "\r\n" . '					if ( col >= 0 )' . "\r\n" . '					{' . "\r\n" . '						//find the cell with the correct index' . "\r\n" . '						var c = getCell(this, cells, col);' . "\r\n" . '						//cell not found - maybe a previous one has a colspan? - search it!' . "\r\n" . '						if ( !c )' . "\r\n" . '						{' . "\r\n" . '							var cco = col;' . "\r\n" . '							while ( cco > 0 && !(c = getCell(this, cells, --cco)) ) {} //find the previous cell' . "\r\n" . '							if ( !c )' . "\r\n" . '							{' . "\r\n" . '								continue;' . "\r\n" . '							}' . "\r\n" . '						}' . "\r\n" . '						//set toggle direction' . "\r\n" . '						if ( colsVisible[col] == undefined )//not initialized yet' . "\r\n" . '						{' . "\r\n" . '							colsVisible[col] = true;' . "\r\n" . '						}' . "\r\n" . '						if ( colsVisible[col] )' . "\r\n" . '						{' . "\r\n" . '							toggle = cmo && cmo.hide ? cmo.hide : hideCell;' . "\r\n" . '							di = -1;' . "\r\n" . '						}' . "\r\n" . '						else' . "\r\n" . '						{' . "\r\n" . '							toggle = cmo && cmo.show ? cmo.show : showCell;' . "\r\n" . '							di = 1;' . "\r\n" . '						}' . "\r\n" . '						if ( !c.chSpan )' . "\r\n" . '						{' . "\r\n" . '							c.chSpan = 0;' . "\r\n" . '						}' . "\r\n" . '						//the cell has a colspan - so dont show/hide - just change the colspan' . "\r\n" . '						if ( c.colSpan > 1 || (di == 1 && c.chSpan && cellVisible(c)) )' . "\r\n" . '						{' . "\r\n" . '							//is the colspan even reaching this cell? if not we have a rowspan -> nothing to do' . "\r\n" . '							if ( c.realIndex + c.colSpan + c.chSpan - 1 < col )' . "\r\n" . '							{' . "\r\n" . '								continue;' . "\r\n" . '							}' . "\r\n" . '							c.colSpan += di;' . "\r\n" . '							c.chSpan += di * -1;' . "\r\n" . '						}' . "\r\n" . '						else if ( c.realIndex + c.chSpan < col )//a previous cell was found, but doesn\'t affect this one (rowspan)' . "\r\n" . '						{' . "\r\n" . '							continue;' . "\r\n" . '						}' . "\r\n" . '						else //toggle cell' . "\r\n" . '						{' . "\r\n" . '							toggle(c);' . "\r\n" . '						}' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '			//set the colsVisible var' . "\r\n" . '			for ( i = 0; i < columns.length; i++ )' . "\r\n" . '			{' . "\r\n" . '				this.cMColsVisible[columns[i] - 1] = !colsVisible[columns[i] - 1];' . "\r\n" . '				//set the appropriate classes to the column header list, if the options have been passed' . "\r\n" . '				if ( cmo && cmo.listTargetID && ( cmo.onClass || cmo.offClass ) )' . "\r\n" . '				{' . "\r\n" . '					var onC = cmo.onClass, offC = cmo.offClass, $li;' . "\r\n" . '					if ( colsVisible[columns[i] - 1] )' . "\r\n" . '					{' . "\r\n" . '						onC = offC;' . "\r\n" . '						offC = cmo.onClass;' . "\r\n" . '					}' . "\r\n" . '					$li = $("#" + cmo.listTargetID + " li").filter(function(){return this.cmData && this.cmData.col == columns[i] - 1;});' . "\r\n" . '					if ( onC )' . "\r\n" . '					{' . "\r\n" . '						$li.removeClass(onC);' . "\r\n" . '					}' . "\r\n" . '					if ( offC )' . "\r\n" . '					{' . "\r\n" . '						$li.addClass(offC);' . "\r\n" . '					}' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '			saveCurrentValue(this);' . "\r\n" . '		});' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Shows all table columns.' . "\r\n" . '	 * When columns are passed through the parameter only the passed ones become visible.' . "\r\n" . '	 *' . "\r\n" . '	 * @param {integer|array} columns		A number or an array of numbers. Each column with the matching column index will become visible.' . "\r\n" . '	 *							Column index starts at 1!' . "\r\n" . '	 *' . "\r\n" . '	 * @param {map} options		An object for optional settings which will get passed to $().toggleColumns().' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').showColumns();' . "\r\n" . '	 * @desc Sets the visibility state of all hidden columns to visible.' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').showColumns(3);' . "\r\n" . '	 * @desc Show column number three.' . "\r\n" . '	 *' . "\r\n" . '	 * @type jQuery' . "\r\n" . '	 *' . "\r\n" . '	 * @name showColumns' . "\r\n" . '	 * @cat Plugins/columnManager' . "\r\n" . '	 * @author Roman Weich (http://p.sohei.org)' . "\r\n" . '	 */' . "\r\n" . '	$.fn.showColumns = function(columns, cmo)' . "\r\n" . '	{' . "\r\n" . '        return this.each(function() ' . "\r\n" . '        {' . "\r\n" . '			var i,' . "\r\n" . '				cols = [],' . "\r\n" . '				cV = this.cMColsVisible;' . "\r\n" . '			if ( cV )' . "\r\n" . '			{' . "\r\n" . '				if ( columns && columns.constructor == Number ) ' . "\r\n" . '					columns = [columns];' . "\r\n" . '' . "\r\n" . '			    //2013-08-22 �޶�' . "\r\n" . '			   	for ( i = 0; i < columns.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					this.cMColsVisible[columns[i] - 1] = false;' . "\r\n" . '				}' . "\r\n" . '' . "\r\n" . '				for ( i = 0; i < cV.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					//if there were no columns passed, show all - or else show only the columns the user wants to see' . "\r\n" . '					if ( !cV[i] && (!columns || $.inArray(i + 1, columns) > -1) )' . "\r\n" . '						cols.push(i + 1);' . "\r\n" . '				}' . "\r\n" . '				' . "\r\n" . '				$(this).toggleColumns(cols, cmo);' . "\r\n" . '			}' . "\r\n" . '			//2013-08-22 �޶�' . "\r\n" . '			else' . "\r\n" . '			{' . "\r\n" . '				this.cMColsVisible = [];' . "\r\n" . '' . "\r\n" . '				if ( columns && columns.constructor == Number ) ' . "\r\n" . '					columns = [columns];' . "\r\n" . '' . "\r\n" . '			   	for ( i = 0; i < columns.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					this.cMColsVisible[columns[i] - 1] = false;' . "\r\n" . '				}' . "\r\n" . '			}' . "\r\n" . '		});' . "\r\n" . '	};' . "\r\n" . '' . "\r\n" . '	/**' . "\r\n" . '	 * Hides table columns.' . "\r\n" . '	 *' . "\r\n" . '	 * @param {integer|array} columns		A number or an array of numbers. Each column with the matching column index will get hidden.' . "\r\n" . '	 *							Column index starts at 1!' . "\r\n" . '	 *' . "\r\n" . '	 * @param {map} options		An object for optional settings which will get passed to $().toggleColumns().' . "\r\n" . '	 *' . "\r\n" . '	 * @example $(\'#table\').hideColumns(3);' . "\r\n" . '	 * @desc Hide column number three.' . "\r\n" . '	 *' . "\r\n" . '	 * @type jQuery' . "\r\n" . '	 *' . "\r\n" . '	 * @name hideColumns' . "\r\n" . '	 * @cat Plugins/columnManager' . "\r\n" . '	 * @author Roman Weich (http://p.sohei.org)' . "\r\n" . '	 */' . "\r\n" . '	$.fn.hideColumns = function(columns, cmo)' . "\r\n" . '	{' . "\r\n" . '        return this.each(function() ' . "\r\n" . '        {' . "\r\n" . '			var i,' . "\r\n" . '				cols = columns,' . "\r\n" . '				cV = this.cMColsVisible;' . "\r\n" . '			if ( cV )' . "\r\n" . '			{' . "\r\n" . '				if ( columns.constructor == Number ) ' . "\r\n" . '					columns = [columns];' . "\r\n" . '				cols = [];' . "\r\n" . '' . "\r\n" . '				for ( i = 0; i < columns.length; i++ )' . "\r\n" . '				{' . "\r\n" . '					if ( cV[columns[i] - 1] || cV[columns[i] - 1] == undefined )' . "\r\n" . '						cols.push(columns[i]);' . "\r\n" . '				}' . "\r\n" . '				' . "\r\n" . '			}' . "\r\n" . '			$(this).toggleColumns(cols, cmo);' . "\r\n" . '		});' . "\r\n" . '	};' . "\r\n" . '})(jQuery);' . "\r\n" . '';

?>