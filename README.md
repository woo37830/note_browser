The notes site was developed to allow me to record, read, and search
my 'diary' entries over the years.  It combines several separate sources
of data including .diary, Notes_YYYY.txt, and .todo.  Each of these used
different date formats even within them, and overlapped, some entries being
in .diary, while for the same year others were in Notes_YYYY.txt for that
year.

A set of perl scripts were written to parse the Notes_YYYY.txt files and 
output with a standard date/time format to a temporary file.  Another
perl script was written to parse the .diary file and append to the
temporary file.  Each dated entry had all of the lines following the date
up to the next date concatenated into a single line.

The resulting temporary file was sorted which merged the items together
in the proper date sequence and then a perl script was used
to write each year 'YYYY' out into a separate Journal_YYYY.txt file
in order to make appending to the 'diary' a bit faster as it did not
need to load all of the previous years data, but just append to the
current years Journal.

A php routine was written to output the text data in a Journal file
as html on a 'page'.  An index.html file was created to list the years,
and provide the link to view that years journal entries and also had
a 'tail' of the latest year as 'recent' entries and added the
current todo list.

Forward and backward links were provided, but since some years were missing
those pages were filled in as 'blank' to keep from having hard logic.
This might be revisited by explicitely adjusting for the years known
to be missing.

2020-02-09 10:17:00

2020-03-07 17:05:00

Added a section to view Billing customers and also turn it on and off.
Still need to write the report from here.
