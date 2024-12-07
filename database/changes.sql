ALTER TABLE NotificationItems
ADD IsCustomNotification BIT DEFAULT 0 NOT NULL,
    CustomMessage NVARCHAR(MAX) NULL;