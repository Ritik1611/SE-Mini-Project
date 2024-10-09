from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time
import random

# Initialize the WebDriver
driver = webdriver.Chrome()  # Use the appropriate WebDriver for your browser

# Function to log in as a teacher
def login_as_teacher(teacher_email, teacher_password):
    driver.get("http://localhost:3000/index.html")  # Replace with your login URL
    time.sleep(2)  # Wait for the page to load
    
    email_input = driver.find_element(By.NAME, "email")  # Replace with actual name attribute
    password_input = driver.find_element(By.NAME, "password")  # Replace with actual name attribute
    
    email_input.clear()
    password_input.clear()
    
    email_input.send_keys(teacher_email)
    password_input.send_keys(teacher_password)
    
    password_input.send_keys(Keys.RETURN)  # Press Enter to log in
    time.sleep(3)  # Wait for the login to process

# Function to add a dummy student
def add_dummy_student(name, division):
    driver.get("http://your-add-student-page-url.com")  # Replace with your add student URL
    time.sleep(2)  # Wait for the page to load
    
    name_input = driver.find_element(By.NAME, "name")  # Replace with actual name attribute
    division_input = driver.find_element(By.NAME, "division")  # Replace with actual name attribute
    
    name_input.clear()
    division_input.clear()
    
    name_input.send_keys(name)
    division_input.send_keys(division)
    
    submit_button = driver.find_element(By.XPATH, "//button[text()='Add Student']")  # Replace with actual button text or element
    submit_button.click()
    
    time.sleep(2)  # Wait for the student to be added

# Function to add marks for a student
def add_marks(division, subject):
    driver.get("http://your-give-marks-page-url.com")  # Replace with your give marks URL
    time.sleep(2)  # Wait for the page to load

    division_input = driver.find_element(By.NAME, "division")
    subject_input = driver.find_element(By.NAME, "subject")

    division_input.clear()
    subject_input.clear()

    division_input.send_keys(division)
    subject_input.send_keys(subject)

    submit_button = driver.find_element(By.XPATH, "//button[text()='Check Roll Numbers']")
    submit_button.click()
    
    time.sleep(3)  # Wait for roll numbers to load
    
    # Enter marks for each roll number
    roll_numbers_div = driver.find_element(By.ID, "rollNumbers")
    roll_inputs = roll_numbers_div.find_elements(By.TAG_NAME, "input")
    
    for roll_input in roll_inputs:
        roll_input.send_keys(random.randint(1, 100))  # Assign random marks between 1 and 100

    submit_marks_button = driver.find_element(By.XPATH, "//button[text()='Submit Marks']")
    submit_marks_button.click()
    
    time.sleep(2)  # Wait for marks to be submitted

# Dummy data for teachers and students
teacher_credentials = [
    {"email": f"teacher{num}@example.com", "password": "password123"} for num in range(1, 11)
]
students = [("Student A", "Class 1"), ("Student B", "Class 1"), ("Student C", "Class 2")]

# Main logic
for teacher in teacher_credentials:
    login_as_teacher(teacher["email"], teacher["password"])
    for student in students:
        add_dummy_student(student[0], student[1])
    add_marks("Class 1", "Math")  # Example for adding marks
    add_marks("Class 2", "Science")  # Example for adding marks

# Close the WebDriver
driver.quit()
