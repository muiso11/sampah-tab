import psycopg2
import pandas as pd
import matplotlib.pyplot as plt
import webbrowser
from reportlab.lib.pagesizes import letter,A4
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
def text(c,x,y,jenis,size,nama):
    textobject = c.beginText(x,y)
    textobject.setFont(jenis, size, leading = None)
    textobject.textOut(nama)    
    c.drawText(textobject)
def kotak(c,x,y,width,height,fill):
    c.rect(x,y,width,height, stroke=1, fill=fill)
def generatePDF(c):
    # Tulisan    
    text(c,260,785,"Helvetica-Bold",12,"EMS REPORT")

    text(c,210,765,"Helvetica",7,"Room/Grade        : Primary Packaging 8A-3/EA")
    text(c,210,750,"Helvetica",7,"Location          : Production Line 8A")
    text(c,210,735,"Helvetica",7,"Periode           : 8-Feb-23")

    text(c,95,697,"Helvetica-Bold",6,"Date")
    text(c,160,697,"Helvetica-Bold",6,"Time")
    text(c,210,692,"Helvetica-Bold",6,"Temperature")
    
    # Garis
    c.line(70,780,530,780)    
    c.line(75,680,525,680)    

    c.line(135,680,135,720)    
    c.line(195,680,195,720)    
    c.line(195,712,525,712)    
    c.line(260,680,260,712)    
    # Gambar
    c.drawImage('kalbe.png', 70,735, width=100,height=40,mask=None)

    # Kotak
    kotak(c,70,200,460,600,0)
    kotak(c,75,250,450,470,0)

c = canvas.Canvas('myfile.pdf', pagesize=A4)
generatePDF(c)

c.showPage()
c.save()