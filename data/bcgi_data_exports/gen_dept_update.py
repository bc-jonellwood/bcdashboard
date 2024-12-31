import json

# Load the JSON data from the file


def load_json_file(filename):
    with open(filename, "r") as file:
        return json.load(file)

# Generate SQL update statements


def generate_sql_statements(data, output_file):
    with open(output_file, "w") as file:
        for entry in data:
            ifas = entry.get("ifas", "NULL")
            email = entry.get("email", "NULL")
            telmc = entry.get("telmc", "NULL")
            telfax = entry.get("telfax", "NULL")
            hours = entry.get("hours", "NULL")
            contact_us = entry.get("contact_us", "NULL")

            # Escape single quotes in strings
            email = email.replace("'", "''") if email != "NULL" else email
            telmc = telmc.replace("'", "''") if telmc != "NULL" else telmc
            telfax = telfax.replace("'", "''") if telfax != "NULL" else telfax
            hours = hours.replace("'", "''") if hours != "NULL" else hours
            contact_us = contact_us.replace(
                "'", "''") if contact_us != "NULL" else contact_us

            # Construct the SQL UPDATE statement
            sql = (
                f"UPDATE data_departments SET "
                f"sEmail = '{email}', "
                f"sTelephone = '{telmc}', "
                f"sFax = '{telfax}', "
                f"sHours = '{hours}', "
                f"sContactEmail = '{contact_us}' "
                f"WHERE iDepartmentNumber = {ifas};"
            )

            # Write the SQL statement to the file
            file.write(sql + "\n")

# Main function


def main():
    input_file = "departments_pods_export.json"
    output_file = "update_statements.sql"

    try:
        # Load JSON data
        data = load_json_file(input_file)

        # Generate SQL statements
        generate_sql_statements(data, output_file)

        print(f"SQL update statements have been written to {output_file}.")
    except Exception as e:
        print(f"An error occurred: {e}")


if __name__ == "__main__":
    main()
