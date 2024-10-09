CREATE TABLE PurchaseContractUploads (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    FilePath NVARCHAR(255),
    PurchaseContractID INT,
    UploadedBy NVARCHAR(255),
    UploadedDate DATETIME,
    CONSTRAINT FK_PurchaseContractUploads_PurchaseContract
        FOREIGN KEY (PurchaseContractID) REFERENCES PurchaseContracts(ID)
);
CREATE TABLE EmployeeContractUploads (
    ID INT IDENTITY(1,1) PRIMARY KEY,
    FilePath NVARCHAR(255),
    EmployeeContractID INT,
    UploadedBy NVARCHAR(255),
    UploadedDate DATETIME,
    CONSTRAINT FK_EmployeeContractstUploads_PurchaseContract
        FOREIGN KEY (EmployeeContractID) REFERENCES EmployeeContracts(ID)
);
