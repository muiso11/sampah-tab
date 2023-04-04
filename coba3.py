import psycopg2
import pandas as pd
import matplotlib.pyplot as plt
import webbrowser
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
from tkinter import *
from tkinter import filedialog
from tkinter import ttk
from tkinter import messagebox
from reportlab.lib import colors
from reportlab.lib.pagesizes import letter, inch
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle

from tkcalendar import DateEntry
import pytz
import datetime 
from datetime import datetime

conn = None

# Create a connection to the database
try:
    conn = psycopg2.connect(
        database="mach",
        user="administrator",
        password="EngSoDB",
        host="172.24.1.101",
        port="5432"
    )
    print("Connection established successfully")
except Exception as e:
    print(f"Unable to connect to the database: {e}")

# Create a cursor object untuk memakai perintah seperti execute guna menampilkan table
cur = conn.cursor()



# Create the main window of the application
root = Tk()
root.title("Report Generator")
root.geometry("500x600")

def select_directory():
    directory = filedialog.askdirectory()
    directory_entry.delete(0, END)
    directory_entry.insert(0, directory)

# Define a function to fetch data from the database and create a report
def generate_report():
    global conn, cur
    # Get the selected table name, date range, and time range
    table_name = table_list.get()
    start_date = start_date_picker.get_date().strftime("%Y-%m-%d")
    end_date = end_date_picker.get_date().strftime("%Y-%m-%d")
    start_time = start_time_picker.get().replace(":", "") + "00"
    end_time = end_time_picker.get().replace(":", "") + "00"

    # Fetch data from the database for the selected date and time range
    cur.execute(f"SELECT datetime, air_flow, inlet_temp, outlet_temp FROM public.{table_name} WHERE datetime BETWEEN '{start_date} {start_time}' AND '{end_date} {end_time}'")
    rows = cur.fetchall()

    # Convert the data into a Pandas dataframe
    df = pd.DataFrame(rows, columns=["datetime", "air_flow", "inlet_temp", "outlet_temp"])
    df["datetime"] = df["datetime"].dt.tz_localize(None)

    # Generate a line chart of the air flow data
    plt.figure(figsize=(12,6))
    plt.plot(df["datetime"], df["air_flow"])
    plt.xlabel("Date")
    plt.ylabel("Air Flow")
    plt.title("Air Flow vs. Date")
    plt.savefig("air_flow.png")
    
    # Generate a line chart of the inlet temp  data
    plt.figure(figsize=(12,6))
    plt.plot(df["datetime"], df["inlet_temp"])
    plt.xlabel("Date")
    plt.ylabel("Inlet Temperature")
    plt.title("Inlet Temperature vs. Date")
    plt.savefig("inlet_temp.png")
    
    # Generate a line chart of the outlet temp  data
    plt.figure(figsize=(12,6))
    plt.plot(df["datetime"], df["outlet_temp"])
    plt.xlabel("Date")
    plt.ylabel("Outlet Temperature")
    plt.title("Outlet Temperature vs. Date")
    plt.savefig("outlet_temp.png")

    # Generate a PDF report
    c = canvas.Canvas(f"{name.get()}_report.pdf", pagesize=letter)
    c.drawString(20, 750, "Report for Air Flow Data")
    c.drawString(20, 650, f"Table Name: {table_name}")
    c.drawString(20, 600, f"Date Range: {start_date} to {end_date}")
    c.drawString(20, 550, f"Time Range: {start_time} to {end_time}")
    c.drawImage("air_flow.png", 50, 430, width=170, height=85)
    c.drawImage("inlet_temp.png", 220, 430, width=170, height=85)
    c.drawImage("outlet_temp.png", 390, 430, width=170, height=85)

   # Add a table with the fetched data from the database
    table_header = ["Datetime", "Air Flow", "Inlet Temp", "Outlet Temp"]
    table_data = [table_header] + rows[:25]  # limit the rows to a maximum of 24
    table_style = [('GRID', (0, 0), (-1, -1), 1, colors.Color(.980392,.921569,.843137,1)),('FONTNAME', (0, 0), (-1,-1), 'Helvetica')]
    table = Table(table_data)
    table.setStyle(TableStyle(table_style))

    # Check if the table fits on the current page
    available_height = 300  # change to match your document size
    table_height = table.wrapOn(c, 0, 0)[1]
    if available_height < table_height:
        c.showPage()
        c.setFont('Helvetica', 12)
        c.drawString(50, 750, "Table Data Configuration")
        y = 250  # adjust the starting y-coordinate to leave space for the continuation text
    else:
        y = 300 - table_height

    table.drawOn(c, 50, y)



    c.save()

    # Generate an Excel report
    df.to_excel(f"{name.get()}_report.xlsx", index=False)

    # Open the generated PDF file
    webbrowser.open(f"{name.get()}_report.pdf")

    # Show a success message
    messagebox.showinfo("Success", "Report generated successfully")

    report_generated_label = Label(root, text="", fg="green")
    report_generated_label.pack()

def clear_fields():
    name.delete(0, END)
    table_list.current(0)
    start_date_picker.set_date(datetime.now(pytz.timezone('Asia/Kolkata')))
    start_time_picker.delete(0, END)
    start_time_picker.insert(0, "00:00")
    end_date_picker.set_date(datetime.now(pytz.timezone('Asia/Kolkata')))
    end_time_picker.delete(0, END)
    end_time_picker.insert(0, "23:59")
    
directory_label = Label(root, text="Select directory to save report:")
directory_label.pack()

directory_button = Button(root, text="Select Directory", command=select_directory)
directory_button.pack()

directory_entry = Entry(root, width=50)
directory_entry.pack()

report_label = Label(root, text="Report Parameters:")
report_label.pack()

name_label = Label(root, text="Your Name:")
name_label.pack()
name = Entry(root)
name.pack()

table_list_label = Label(root, text="Table List:")
table_list_label.pack()
table_list = ttk.Combobox(root, values=["m0101_dfx1200_01"])
table_list.current(0)
table_list.pack()

start_date_label = Label(root, text="Start Date:")
start_date_label.pack()
start_date_picker = DateEntry(root, width=12, background='darkblue',
foreground='white', borderwidth=2, date_pattern='yyyy-mm-dd')
start_date_picker.pack()

start_time_label = Label(root, text="Start Time:")
start_time_label.pack()
start_time_picker = Entry(root)
start_time_picker.insert(0, "00:00")
start_time_picker.pack()

end_date_label = Label(root, text="End Date:")
end_date_label.pack()
end_date_picker = DateEntry(root, width=12, background='darkblue',
foreground='white', borderwidth=2, date_pattern='yyyy-mm-dd')
end_date_picker.pack()

end_time_label = Label(root, text="End Time:")
end_time_label.pack()
end_time_picker = Entry(root)
end_time_picker.insert(0, "23:59")
end_time_picker.pack()

# create a button to submit the form
generate_button = Button(root, text="Generate Report", command=generate_report)
generate_button.pack()

clear_button = Button(root, text="Clear Fields", command=clear_fields)
clear_button.pack()

root.mainloop()

    
