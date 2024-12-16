INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84450, '2007 Chevrolet Impala', 4, 100070, 1, 1154, '2G1WB55K8793',  0, 0, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84451, '2008 Chevrolet Impala', 4, 16663, 0, 1214, '2G1WB55K581312254',  0, 83180, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84452, '2011 Chevrolet Impala', 4, 35258, 0, 1360, '2G1WF5EK2B1298258',  0, 98122, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84453, '2015 Ford Escape', 5, 83012, 0, 1526, '1FMCU9G96FUB82567',  1, 121036, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84454, '2015 Ford Escape', 5, 70334, 0, 1563, '1FMCU9GXXFUC89863',  1, 92473, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84455, '2005 Ford Crown Victoria', 5, 54202, 1, 1051, '2FAFP71W75X162823',  0, 0, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84456, '2007 Chevrolet Trailblazer', 5, 32169, 1, 1150, '1GNDT13S572215844',  1, 0, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84457, '2008 Toyota Prius', 4, 71582, 1, 1230, , 'JTDKB20U387801915',  0, 0, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84458, '2015 Chevrolet 1500 Truck', 4, 39972, 1, 1573, '1GCRCPEC2FZ421944',  1, 0, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(84459, '2017 Ford Escape', 4, 91322, 0, 1657, '1FMCU9GD1HUC04014',  1, 97542, 0);
INSERT INTO data_mp_vehicles (iLegacyId, sVehName, iVehMaxOccupancy, iVehOdometer, bIsRetired, sVehUnitNum, sVehVin, bVehCargoSpace, iVehNextServiceOdometer, bOutForService) VALUES(137160, '2012 Chevy Impala', 4, 33800, 0, 1388, '2G1WF5E35C1202973',  0, 0, 0);

-- FLeet Garage
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 100; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 101; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 102; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 103; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 104; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 107; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 109; 
update data_mp_vehicles set sVehLocationId = 'c805cc0a-f3d3-430e-bb8e-a7f42d2e64ec' where id = 110; 
-- Goose Creek 
update data_mp_vehicles set sVehLocationId = '2cf5b921-e70f-4445-8957-e291d5025fba' where id = 105; 
-- Admin Bldg
update data_mp_vehicles set sVehLocationId = 'a4bafc49-ee1a-49b5-b6f2-8a5ec5a39034' where id = 106; 
-- Procurement
update data_mp_vehicles set sVehLocationId = 'b64f4641-eb6d-4929-88fc-dc6cf171962f' where id = 108; 

