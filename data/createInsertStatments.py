import csv


def generate_insert_statements(input_file, output_file):
    try:
        with open(input_file, mode='r', newline='', encoding='utf-8') as csvfile:
            reader = csv.reader(csvfile)
            insert_statements = []

            for row in reader:
                # Strip whitespace and handle missing values
                employee_number = row[0].strip() if len(row) > 0 else 'NULL'
                email = row[1].strip() if len(
                    row) > 1 and row[1].strip() else 'NULL'
                phone = row[2].strip() if len(
                    row) > 2 and row[2].strip() else 'NULL'

                # Create the SQL insert statement
                insert_statement = (
                    f"INSERT INTO data_ad (iEmployeeNumber, sEmail, sMainPhoneNumber) "
                    f"VALUES ('{employee_number}', '{email}', '{phone}')"
                )

                insert_statements.append(insert_statement)

        # Write the insert statements to the output file
        with open(output_file, mode='w', encoding='utf-8') as outfile:
            for statement in insert_statements:
                outfile.write(statement + '\n')

        print(f"Insert statements successfully written to {output_file}")

    except FileNotFoundError:
        print(f"Error: The file {input_file} was not found.")
    except Exception as e:
        print(f"An error occurred: {e}")


# Example usage
generate_insert_statements('empsAll.csv', 'insert_ad.sql')
