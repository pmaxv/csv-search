The script for searching data in CSV file

The script receives as input the path to a CSV file to be imported, a 
column number in which to search, and a search key.

The script must be invoked in this way:

$ php search.php ./file.csv 2 Alberto

where ./file.csv is the path to a CSV file formatted in this way:
1,Rossi,Fabio,01/06/1990;
2,Gialli,Alessandro,02/07/1989;
3,Verdi,Alberto,03/08/1987;

The number 2 represents the index of the column to search in (in the 
previous file the name) and Alberto represents the search key.

### Requirements
* PHP >= 7.0.x