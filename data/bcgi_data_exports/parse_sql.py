import csv


def process_line(row):
    # Create the insert statement with each field in single quotes
    insert_statement = (
        f"INSERT INTO data_mp_vehicles (iLegacyId, sVehUnitNum, sVehMake, sVehModel, sVehYear, sVehVin, iVehOdometer) VALUES ("
        + ', '.join([f"'{field}'" for field in row])
        + ");"
    )
    return insert_statement


def process_file(input_filepath, output_filepath):
    with open(input_filepath, 'r') as infile, open(output_filepath, 'w') as outfile:
        reader = csv.reader(infile)
        for row in reader:
            new_line = process_line(row)
            outfile.write(new_line + '\n')


if __name__ == "__main__":
    input_filepath = 'vehicle_data_export.csv'
    output_filepath = 'insert_data_processed.sql'
    process_file(input_filepath, output_filepath)
